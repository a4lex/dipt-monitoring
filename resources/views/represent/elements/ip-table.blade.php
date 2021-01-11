{{
    is_numeric($item->$columnName)
        ? long2ip($item->$columnName)
        : $item->$columnName
}}
