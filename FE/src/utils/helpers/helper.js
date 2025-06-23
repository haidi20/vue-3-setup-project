import _ from "lodash";
import Swal from "sweetalert2";

// ======================
// mengubah semua string pada data 
// (termasuk di dalam array dan object nested) menjadi huruf kapital (uppercase),
// ======================

export const transformValue = (value) => {
    if (value instanceof File || value instanceof Blob) return value;

    if (Array.isArray(value)) {
        return value.map((item) => transformValue(item));
    }

    if (typeof value === "object" && value !== null) {
        return Object.fromEntries(
            Object.entries(value).map(([key, val]) => [key, transformValue(val)])
        );
    }

    if (typeof value === "string") {
        return value.toUpperCase();
    }

    return value;
};

// ======================
// TREE STRUCTURE DAN FLATTENING
// ======================
export const flattenPositions = (data) => {
    const result = [];

    const traverse = (node) => {
        const { parent, ...rest } = node;
        result.push(rest);
        if (parent) {
            traverse(parent);
        }
    };

    data.forEach((node) => traverse(node));

    return result;
};

// ======================
// FORMAT DAN PERHITUNGAN HARGA
// ======================
export const setNumberOnly = (value) => {
    if (!value) return 0;
    const numericValue = value.replace(/,/g, "");
    return parseInt(numericValue, 10);
};

// keyup number only
// @keypress="allowOnlyNumber"
// methods
// allowOnlyNumber(event) {
//     const key = event.key;
//     if (!/[0-9]/.test(key)) {
//         event.preventDefault(); // tolak input selain angka
//     }
// }

// ======================
// FORMAT RUPIAH
// ======================
export const formatRupiah = (value) => {
    let numberString = value.toString().replace(/[^.\d]/g, ""),
        sisa = numberString.length % 3,
        rupiah = numberString.substr(0, sisa),
        ribuan = numberString.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        let separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }

    return rupiah;
};

export const swalColors = {
    merah: "#e74c3c",
    hijau: "#2ecc71",
    biru: "#3498db",
    kuning: "#f1c40f",
    abuAbu: "#95a5a6",
    ungu: "#9b59b6",
};

// ======================
// SWEETALERT TOAST DAN CONFIRM
// ======================
export const swalToast = ({
    title = null,
    icon = "warning",
    position = "top-right",
    isToast = true,
    timer = 2000,
    showConfirmButton = false,
    timerProgressBar = true,
    cancelButtonColor = '#3085d6', // opsional
    confirmButtonText = 'Oke',
    confirmButtonColor = '#3085d6', // ← Warna biru untuk tombol konfirmasi
} = {}) => {
    const Toast = Swal.mixin({
        toast: isToast,
        position,
        timer,
        timerProgressBar: timerProgressBar,
        showConfirmButton: showConfirmButton,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    if (showConfirmButton) {
        Toast.mixin({
            showConfirmButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: cancelButtonColor,
            confirmButtonText: confirmButtonText,
        });
    }

    Toast.fire({
        icon,
        title,
    });
};

// ======================
// SWEETALERT CONFIRM DIALOG
// ======================
export const swalConfirm = async ({
    html = null,
    icon = "success",
    confirmButtonText = "Ya hapus",
    cancelButtonText = "Batal",
    showCancelButton = true,
} = {}) => {
    return new Promise((resolve) => {
        const Toast = Swal.mixin({
            toast: false,
            position: "center",
            showConfirmButton: true,
            showCancelButton: showCancelButton,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: confirmButtonText || "Ya",
            cancelButtonText: cancelButtonText || "Tidak",
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        Toast.fire({
            icon,
            html,
        }).then((result) => {
            resolve(result.isConfirmed);
        });
    });
};

// ======================
// COPY TO CLIPBOARD
// ======================
export const copyText = ({ value }) => {
    if (!value) {
        console.error("No value provided for copying.");
        return;
    }

    navigator.clipboard
        .writeText(value)
        .then(() => {
            swalToast({
                icon: "success",
                position: "top-right",
                is_toast: true,
                title: "Data sudah tercopy",
            });
        })
        .catch((error) => {
            console.error("Failed to copy text: ", error);
            swalToast({
                icon: "error",
                position: "top-right",
                is_toast: true,
                title: "Gagal menyalin data",
            });
        });
};

// ======================
// GET DURASI TERBACA
// ======================
export function getDurationReadable(startDateStr, endDateStr) {
    if (!startDateStr || !endDateStr) return "Tidak tersedia";
    const startDate = new Date(startDateStr);
    const endDate = new Date(endDateStr);
    const diffMs = endDate - startDate;
    if (isNaN(diffMs) || diffMs < 0) return "Tidak tersedia";

    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    if (diffDays < 7) {
        return `${diffDays} Hari`;
    } else if (diffDays < 30) {
        const weeks = Math.floor(diffDays / 7);
        return `${weeks} Minggu`;
    } else if (diffDays < 365) {
        const months = Math.floor(diffDays / 30);
        return `${months} Bulan`;
    } else {
        const years = Math.floor(diffDays / 365);
        return `${years} Tahun`;
    }
}

/**
 * Menghasilkan rentang tanggal yang optimal (1 Januari 2024, 1–5 Januari 2024, dst)
 */
export function getStartAndEndDateReadable(startDateStr, endDateStr) {
    if (!startDateStr || !endDateStr) return "Tidak tersedia";

    const startDate = new Date(startDateStr);
    const endDate = new Date(endDateStr);

    // Jika tanggal sama
    if (
        startDate.getDate() === endDate.getDate() &&
        startDate.getMonth() === endDate.getMonth() &&
        startDate.getFullYear() === endDate.getFullYear()
    ) {
        return startDate.toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    }

    // Jika bulan dan tahun sama
    if (
        startDate.getMonth() === endDate.getMonth() &&
        startDate.getFullYear() === endDate.getFullYear()
    ) {
        return `${startDate.getDate()}–${endDate.getDate()} ${startDate.toLocaleDateString("id-ID", {
            month: "long",
            year: "numeric",
        })}`;
    }

    // Jika tahun sama
    if (startDate.getFullYear() === endDate.getFullYear()) {
        return `${startDate.getDate()} ${startDate.toLocaleDateString("id-ID", {
            month: "long",
        })} – ${endDate.getDate()} ${endDate.toLocaleDateString("id-ID", {
            month: "long",
            year: "numeric",
        })}`;
    }

    // Tahun berbeda
    return `${startDate.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    })} – ${endDate.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    })}`;
}

/**
 * Menghitung tanggal expired berdasarkan deadline integer dan periodenya.
 * @param {integer} deadline - Jumlah hari dari hari ini
 * @param {'day'|'week'|'month'} deadline_period - Periode penambahan
 * @returns {{ expired_at: string, expired_at_readable: string }}
 */
export function getExpiredAt(deadline, deadline_period) {
    let expired_at = "";
    let expired_at_readable = "";

    // console.info("deadline", deadline);
    // console.info("deadline_period", deadline_period);

    if (!deadline || !deadline_period) return { expired_at, expired_at_readable };

    // Pastikan deadline adalah integer positif
    const daysToAdd = parseInt(deadline, 10);
    if (isNaN(daysToAdd) || daysToAdd < 0) {
        console.error("Deadline harus berupa angka positif");
        return { expired_at: "", expired_at_readable: "" };
    }

    // Mulai dari hari ini
    const baseDate = new Date();
    baseDate.setHours(0, 0, 0, 0); // Set ke awal hari agar konsisten

    let expiredDate = new Date(baseDate);

    // Hitung expiredDate berdasarkan period
    if (deadline_period === 'day') {
        expiredDate.setDate(baseDate.getDate() + daysToAdd);
    } else if (deadline_period === 'week') {
        expiredDate.setDate(baseDate.getDate() + daysToAdd * 7);
    } else if (deadline_period === 'month') {
        expiredDate.setMonth(baseDate.getMonth() + daysToAdd);
    }

    // Format ISO untuk expired_at
    expired_at = expiredDate.toISOString().slice(0, 10);

    // Format readable (Bahasa Indonesia)
    const bulanIndo = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const tanggal = expiredDate.getDate();
    const bulan = bulanIndo[expiredDate.getMonth()];
    const tahun = expiredDate.getFullYear();

    expired_at_readable = `${tanggal} ${bulan} ${tahun}`;

    return { expired_at, expired_at_readable };
}

// ======================
// FILTER REFERENCE CREATOR
// ======================

export const createFilterRef = (filterKey) => {
    return {
        get() {
            return this.$store.state[this.name_space].table_options[this.status_data]
                ?.filters[filterKey];
        },
        set(val) {
            const payload = {
                filter: {},
                status_data: this.status_data,
            };
            payload.filter[filterKey] = val;
            // console.info("payload", payload);
            this.UPDATE_FILTERS(payload);
        },
    };
}

// ======================
// GET DATE TIME READABLE
// ======================
export const getDateTimeReadable = (datetime) => {
    const date = new Date(datetime);
    // Array nama hari dan bulan dalam bahasa Indonesia
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const dayName = days[date.getDay()];
    const day = date.getDate();
    const monthName = months[date.getMonth()];
    const year = date.getFullYear();
    const hour = date.getHours().toString().padStart(2, '0');
    const minute = date.getMinutes().toString().padStart(2, '0');

    return {
        dayName,
        day,
        monthName,
        year,
        hour,
        minute,
    };
};


/**
 * Mengembalikan jarak waktu (misal: "5 menit", "2 jam 10 menit", "3 hari 4 jam") dari sekarang sampai ke tanggal yang diberikan.
 * Jika tanggal sudah lewat, tambahkan kata "sudah lewat".
 * @param {string|Date} date - Tanggal/waktu tujuan (masa depan atau masa lalu)
 * @returns {string}
 */
export function getTimeDistanceReadable(date) {
    if (!date) return "Tidak tersedia";

    const now = new Date();
    const target = new Date(date);

    // Cek validitas tanggal
    if (isNaN(target.getTime())) return "Tidak tersedia";

    const isPast = target < now;
    let diffMs = Math.abs(target - now);

    const seconds = Math.floor(diffMs / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(months / 12);

    let result = "";

    if (seconds < 60) {
        result = `${seconds} detik`;
    } else if (minutes < 60) {
        const sisaDetik = seconds % 60;
        result = sisaDetik > 0
            ? `${minutes} menit ${sisaDetik} detik`
            : `${minutes} menit`;
    } else if (hours < 24) {
        const sisaMenit = minutes % 60;
        result = sisaMenit > 0
            ? `${hours} jam ${sisaMenit} menit`
            : `${hours} jam`;
    } else if (days < 30) {
        const sisaJam = hours % 24;
        result = sisaJam > 0
            ? `${days} hari ${sisaJam} jam`
            : `${days} hari`;
    } else if (months < 12) {
        const sisaHari = days % 30;
        result = sisaHari > 0
            ? `${months} bulan ${sisaHari} hari`
            : `${months} bulan`;
    } else {
        const sisaBulan = months % 12;
        result = sisaBulan > 0
            ? `${years} tahun ${sisaBulan} bulan`
            : `${years} tahun`;
    }

    if (isPast) {
        result = "sudah lewat " + result;
    }
    return result;
}

