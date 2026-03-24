import re


def to_pascal_case(name: str) -> str:
    """equipment_category -> EquipmentCategory"""
    return "".join(word.capitalize() for word in name.split("_"))


def to_camel_case(name: str) -> str:
    """equipment_category -> equipmentCategory"""
    pascal = to_pascal_case(name)
    return pascal[0].lower() + pascal[1:] if pascal else pascal


def to_kebab_case(name: str) -> str:
    """EquipmentCategory -> equipment-category  OR  equipment_category -> equipment-category"""
    # Handle snake_case input
    if "_" in name:
        return name.replace("_", "-").lower()
    # Handle PascalCase input
    s = re.sub(r"(?<!^)(?=[A-Z])", "-", name).lower()
    return s


def to_package_path(package: str) -> str:
    """com.example.userservice -> com/example/userservice"""
    return package.replace(".", "/")


def to_artifact_id(service_name: str) -> str:
    """user-service -> user-service  (already kebab, just lowercase)"""
    return service_name.lower().replace("_", "-")


def to_app_class_name(service_name: str) -> str:
    """user-service -> UserService"""
    return "".join(word.capitalize() for word in re.split(r"[-_]", service_name))


def to_package_suffix(service_name: str) -> str:
    """user-service -> userservice"""
    return re.sub(r"[-_]", "", service_name).lower()


def singularize(name: str) -> str:
    """Naive singularization: equipments -> equipment, categories -> category"""
    if name.endswith("ies"):
        return name[:-3] + "y"
    if name.endswith("ses") or name.endswith("xes") or name.endswith("zes"):
        return name[:-2]
    if name.endswith("s") and not name.endswith("ss"):
        return name[:-1]
    return name


def table_to_class_name(table_name: str) -> str:
    """equipments -> Equipment, user_roles -> UserRole"""
    singular = singularize(table_name)
    return to_pascal_case(singular)


def table_to_url_path(table_name: str) -> str:
    """equipment_category -> equipment-categories, user -> users"""
    # Pluralize the last segment for REST convention
    parts = table_name.split("_")
    last = parts[-1]
    if not last.endswith("s"):
        last = last + "s"
    parts[-1] = last
    return "-".join(parts)
