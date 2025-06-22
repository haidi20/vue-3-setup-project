
export function useDashboardData() {
  const columns = [
    { label: "Nama", field: "label" },
    { label: "Nilai", field: "value" },
    { label: "Aksi", field: "actions", },
  ];

  // Edit data by id
  const onEdit = (index, item) => {
    console.log('Real Item:', item)
  }

  // Delete data by index
  const onDelete = (index) => {
    console.log("Deleting data with index:", index);
  }

  return { columns, onEdit, onDelete };
}