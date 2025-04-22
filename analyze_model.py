import sys
import json
import trimesh
import io

material_prices = {
    "PLA": 0.5,
    "PETG": 0.7,
    "ASA/ABS": 0.8
}

material_densities = {
    "pla": 1.24,
    "petg": 1.35,
    "asa/abs": 1.05
}

def analyze_model_from_bytes(data, material, file_type, fixed_cost=5.0):
    try:
        mesh = trimesh.load(io.BytesIO(data), file_type=file_type)

        if mesh.is_empty:
            return {'error': 'Model je prázdný.'}
        if not mesh.is_volume:
            return {'error': 'Model není uzavřený objem (nepůjde vytisknout).'}

        width, height, depth = mesh.bounding_box.extents
        volume_cm3 = mesh.volume / 1000.0 
        price_per_cm3 = material_prices.get(material, 0.15)
        material_key = material.lower()
        density = material_densities.get(material_key, 1.2)
        weight = volume_cm3 * density
        total_price = fixed_cost + (volume_cm3 * price_per_cm3)

        return {
            'width_mm': round(width, 2),
            'height_mm': round(height, 2),
            'depth_mm': round(depth, 2),
            'volume_cm3': round(volume_cm3, 2),
            'weight': round(weight, 2),
            'price_estimate': round(total_price, 2),
            'triangles': mesh.faces.shape[0]
        }

    except Exception as e:
        return {'error': str(e)}

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(json.dumps({'error': 'Očekávám 2 argumenty: materiál a typ souboru (stl/obj)'}))
        sys.exit(1)

    material = sys.argv[1]
    file_type = sys.argv[2].lower()

    try:
        model_data = sys.stdin.buffer.read()
        result = analyze_model_from_bytes(model_data, material, file_type)
        print(json.dumps(result, ensure_ascii=False))
    except Exception as e:
        print(json.dumps({'error': f'Chyba při čtení vstupu: {str(e)}'}))
        sys.exit(1)
