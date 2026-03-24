from .base import BaseGenerator
from .springboot.generator import SpringBootGenerator

_REGISTRY: dict[str, type[BaseGenerator]] = {
    "spring-boot": SpringBootGenerator,
    "springboot": SpringBootGenerator,
}


def get_generator(name: str) -> type[BaseGenerator]:
    key = name.lower().replace("_", "-")
    if key not in _REGISTRY:
        available = ", ".join(_REGISTRY.keys())
        raise ValueError(f"Unknown generator '{name}'. Available: {available}")
    return _REGISTRY[key]


def list_generators() -> list[str]:
    return list(_REGISTRY.keys())
