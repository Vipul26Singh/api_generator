from abc import ABC, abstractmethod
from pathlib import Path

from jinja2 import Environment, FileSystemLoader, StrictUndefined

from ..config.loader import GeneratorConfig, ServiceConfig
from ..parser.models import SchemaModel


class BaseGenerator(ABC):
    """
    Abstract base for all tech-stack generators.

    Subclasses must implement :meth:`generate` and expose
    :attr:`template_dir` pointing to their Jinja2 templates directory.
    """

    def __init__(
        self,
        schema: SchemaModel,
        config: GeneratorConfig,
        output_dir: Path,
    ) -> None:
        self.schema = schema
        self.config = config
        self.output_dir = output_dir
        self._env = Environment(
            loader=FileSystemLoader(str(self.template_dir)),
            undefined=StrictUndefined,
            trim_blocks=True,
            lstrip_blocks=True,
            keep_trailing_newline=True,
        )

    @property
    @abstractmethod
    def template_dir(self) -> Path:
        """Absolute path to the Jinja2 templates directory for this generator."""

    @abstractmethod
    def generate(self) -> None:
        """Generate all output for every service in the config."""

    # ── Shared helpers ────────────────────────────────────────────────────

    def _render(self, template_name: str, context: dict) -> str:
        template = self._env.get_template(template_name)
        return template.render(**context)

    def _write(self, file_path: Path, content: str) -> None:
        file_path.parent.mkdir(parents=True, exist_ok=True)
        file_path.write_text(content, encoding="utf-8")
        print(f"  [+] {file_path}")
