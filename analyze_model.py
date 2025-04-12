import sys
import json
import trimesh

def analyze_model(file_path, price_per_cm3=0.15, fixed_cost=5.0):
    try:
        mesh = trimesh.load(file_path)
        if mesh.is_empty or not mesh.is_volume:
            return {'error': 'Model je prázdný nebo není uzavřený objem.'}

        width, height, depth = mesh.bounding_box.extents
        volume_cm3 = mesh.volume / 1000.0
        price = fixed_cost + (volume_cm3 * price_per_cm3)

        return {
            'width_mm': round(width, 2),
            'height_mm': round(height, 2),
            'depth_mm': round(depth, 2),
            'volume_cm3': round(volume_cm3, 2),
            'price_estimate': round(price, 2),
            'triangles': mesh.faces.shape[0]
        }

    except Exception as e:
        return {'error': f'Chyba při zpracování souboru: {str(e)}'}

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({'error': 'Chybí cesta k souboru'}))
    else:
        file_path = sys.argv[1]
        result = analyze_model(file_path)
        print(json.dumps(result, ensure_ascii=False))
