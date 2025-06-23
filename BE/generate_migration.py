import os
from datetime import datetime, timedelta

# Ganti path sesuai struktur Laravel kamu
MIGRATION_PATH = "database/migrations"
SEEDER_PATH = "database/seeders"

os.makedirs(MIGRATION_PATH, exist_ok=True)
os.makedirs(SEEDER_PATH, exist_ok=True)

# Timestamp awal: 20 Juni 2025 pukul 10:00:00
base_time = datetime(2025, 6, 20, 10, 0, 0)

tables = [
    {"name": "account_categories", "seeder_data": ["Aset", "Liabilitas", "Ekuitas", "Pendapatan", "Beban"]},
    {"name": "account_normal_balances", "seeder_data": ["debit", "kredit"]}
]

for i, table in enumerate(tables):
    # Tambahkan interval 30 detik per file agar tidak sama
    timestamp = (base_time + timedelta(seconds=i * 30)).strftime("%Y_%m_%d_%H%M%S")

    # Nama file migrasi
    migration_file = f"{timestamp}_create_{table['name']}_table.php"
    with open(os.path.join(MIGRATION_PATH, migration_file), "w") as f:
        f.write(f"""<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    public function up(): void
    {{
        Schema::create('{table['name']}', function (Blueprint $table) {{
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        }});
    }}

    public function down(): void
    {{
        Schema::dropIfExists('{table['name']}');
    }}
}};
""")
    print(f"Created migration: {migration_file}")

    # Seeder
    seeder_class = f"{table['name'].title().replace('_', '')}TableSeeder"
    seeder_file = f"{seeder_class}.php"
    seeder_data = ",\n            ".join([f"['name' => '{item}']" for item in table['seeder_data']])
    with open(os.path.join(SEEDER_PATH, seeder_file), "w") as f:
        f.write(f"""<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeders\Seeder;

class {seeder_class} extends Seeder
{{
    public function run()
    {{
        $data = [
            {seeder_data}
        ];

        DB::table('{table['name']}')->insert($data);
    }}
}}
""")
    print(f"Created seeder: {seeder_file}")

print("✅ Semua file migrasi dan seeder telah dibuat.")
