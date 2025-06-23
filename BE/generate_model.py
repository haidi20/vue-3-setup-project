import os

# Konfigurasi direktori output
MODEL_DIR = "app/Models"
NAMESPACE = "App\\Models"

# Daftar model dan fillable fields
models = [
    {
        "class_name": "AccountEstimate",
        "table": "account_estimates",
        "fillable": ["name", "description"]
    },
    {
        "class_name": "BankAccount",
        "table": "bank_accounts",
        "fillable": ["bank_name", "account_number", "account_holder", "branch"]
    },
    {
        "class_name": "FundingSource",
        "table": "funding_sources",
        "fillable": ["source_name", "description"]
    },
    {
        "class_name": "TransactionType",
        "table": "transaction_types",
        "fillable": ["type_name", "description"]
    },
    {
        "class_name": "PaymentType",
        "table": "payment_types",
        "fillable": ["type_name", "description"]
    },
    {
        "class_name": "OrganizationalUnit",
        "table": "organizational_units",
        "fillable": ["unit_name", "description", "parent_id"],
        "relations": [
            "public function parent() { return $this->belongsTo(OrganizationalUnit::class, 'parent_id'); }",
            "public function children() { return $this->hasMany(OrganizationalUnit::class, 'parent_id'); }"
        ]
    },
    {
        "class_name": "AccountingPeriod",
        "table": "accounting_periods",
        "fillable": ["period_name", "start_date", "end_date", "status"],
        "casts": {
            "start_date": "date",
            "end_date": "date"
        }
    },
    {
        "class_name": "CashBook",
        "table": "cash_books",
        "fillable": [
            "account_estimate_id",
            "funding_source_id",
            "payment_type_id",
            "organizational_unit_id",
            "transaction_date",
            "document_number",
            "description",
            "type",
            "amount",
            "reference"
        ],
        "relations": [
            "public function accountEstimate() { return $this->belongsTo(AccountEstimate::class); }",
            "public function fundingSource() { return $this->belongsTo(FundingSource::class); }",
            "public function paymentType() { return $this->belongsTo(PaymentType::class); }",
            "public function organizationalUnit() { return $this->belongsTo(OrganizationalUnit::class); }"
        ]
    }
]

# Template dasar model dengan SoftDeletes dan guarded
model_template = """<?php

namespace {namespace};

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\SoftDeletes;

class {class_name} extends Model
{{
    use HasFactory, SoftDeletes;

    protected $table = '{table}';
    protected $guarded = [];

{casts}

{relations}
}}
"""

# Fungsi untuk menghasilkan bagian casts
def generate_casts(casts):
    if not casts:
        return ""
    cast_str = "    protected $casts = [\n"
    cast_str += ",\n".join(f"        '{k}' => '{v}'" for k, v in casts.items())
    cast_str += "\n    ];"
    return cast_str

# Fungsi untuk menghasilkan bagian relations
def generate_relations(relations):
    if not relations:
        return ""
    return "\n\n" + "\n".join(relations)

# Pastikan direktori model ada
os.makedirs(MODEL_DIR, exist_ok=True)

# Buat file model
for model in models:
    class_name = model["class_name"]
    file_path = os.path.join(MODEL_DIR, f"{class_name}.php")

    content = model_template.format(
        namespace=NAMESPACE,
        class_name=class_name,
        table=model["table"],
        casts=generate_casts(model.get("casts", {})),
        relations=generate_relations(model.get("relations", []))
    )

    # Fix: Ganti {{ dan }} menjadi { dan }
    content = content.replace("{{", "{").replace("}}", "}")

    # Fix: Hilangkan backslash di \$ jadi $
    content = content.replace("\\$", "$")

    with open(file_path, "w") as f:
        f.write(content)

    print(f"✅ Created: {file_path}")
