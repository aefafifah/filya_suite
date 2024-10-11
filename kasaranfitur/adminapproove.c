#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX_ADUAN 100
#define EMAIL_ADMIN "filyasuite@admin.com"
#define PASSWORD_ADMIN "password"
#define NO_TELP_ADMIN "11111111"

struct DataAdmin {
    char email[30];
    char password[30];
    char no_telp[15];
};

struct DataAduTempat {
    int id_pengaduan;
    char nama_pengadu[50];
    char no_telepon_pengadu[15];
    char tanggal_menginap[11];
    char nomor_kamar[10];
    char jenis_masalah[50];
    char deskripsi_masalah[255];
    char waktu_pengaduan[20];
    char file_bukti[50];
    char status[20];
};

struct DataAduFasilitas {
    int id_pengaduan;
    char nama_pengadu[50];
    char no_telepon_pengadu[15];
    char tanggal_menginap[11];
    char tanggal_melaporkan[11];
    char tempat_kerusakan[50];
    char jenis_masalah[50];
    char deskripsi_masalah[255];
    char kategori_fasilitas[50];
    char status[20];
};

struct DataAduKinerja {
    int id_pengaduan;
    char nama_pengadu[50];
    char no_telepon_pengadu[15];
    char tanggal_menginap[11];
    int id_pegawai;
    char nama_pegawai[50];
    char jabatan_pegawai[30];
    char waktu_kejadian[20];
    char jenis_masalah[50];
    char deskripsi_masalah[255];
    char file_bukti[50];
    char status[20];
};

struct Aduan {
    struct DataAduTempat adu_tempat[MAX_ADUAN];
    struct DataAduFasilitas adu_fasilitas[MAX_ADUAN];
    struct DataAduKinerja adu_kinerja[MAX_ADUAN];
    int count_tempat;
    int count_fasilitas;
    int count_kinerja;
};

void login(struct DataAdmin admin) {
    char input[30];

    printf("Silahkan login:\n");
    printf("Masukkan email atau nomor telepon: ");
    scanf("%s", input);
    
    printf("Masukkan password: ");
    char input_password[30];
    scanf("%s", input_password);

    // Check if input is either email or phone number
    if ((strcmp(input, admin.email) == 0 || strcmp(input, admin.no_telp) == 0) &&
        strcmp(input_password, admin.password) == 0) {
        printf("Selamat datang admin\n");
    } else {
        printf("Login gagal! Anda bukan admin.\n");
        exit(0);
    }
}


void beriStatusPengaduanTempat(struct Aduan *aduan) {
    int id;
    char status[20];

    printf("Masukkan ID pengaduan untuk diperbarui: ");
    scanf("%d", &id);

    if (id < 1 || id > aduan->count_tempat) {
        printf("ID pengaduan tidak valid!\n");
        return;
    }

    printf("Masukkan status (diterima, dalam proses, ditolak): ");
    scanf("%s", status);
    strcpy(aduan->adu_tempat[id - 1].status, status);
    printf("Status pengaduan telah diperbarui!\n");
}

void beriStatusPengaduanFasilitas(struct Aduan *aduan) {
    int id;
    char status[20];

    printf("Masukkan ID pengaduan untuk diperbarui: ");
    scanf("%d", &id);

    if (id < 1 || id > aduan->count_fasilitas) {
        printf("ID pengaduan tidak valid!\n");
        return;
    }

    printf("Masukkan status (diterima, dalam proses, ditolak): ");
    scanf("%s", status);
    strcpy(aduan->adu_fasilitas[id - 1].status, status);
    printf("Status pengaduan telah diperbarui!\n");
}

void beriStatusPengaduanKinerja(struct Aduan *aduan) {
    int id;
    char status[20];

    printf("Masukkan ID pengaduan untuk diperbarui: ");
    scanf("%d", &id);

    if (id < 1 || id > aduan->count_kinerja) {
        printf("ID pengaduan tidak valid!\n");
        return;
    }

    printf("Masukkan status (diterima, dalam proses, ditolak): ");
    scanf("%s", status);
    strcpy(aduan->adu_kinerja[id - 1].status, status);
    printf("Status pengaduan telah diperbarui!\n");
}

void tampilkanPengaduanTempat(struct Aduan *aduan) {
    printf("\nDaftar Pengaduan Tempat:\n");
    for (int i = 0; i < aduan->count_tempat; i++) {
        printf("ID: %d, Nama: %s, No Telepon: %s, Tanggal Menginap: %s, Nomor Kamar: %s, Jenis Masalah: %s, Deskripsi: %s, Status: %s\n",
               aduan->adu_tempat[i].id_pengaduan,
               aduan->adu_tempat[i].nama_pengadu,
               aduan->adu_tempat[i].no_telepon_pengadu,
               aduan->adu_tempat[i].tanggal_menginap,
               aduan->adu_tempat[i].nomor_kamar,
               aduan->adu_tempat[i].jenis_masalah,
               aduan->adu_tempat[i].deskripsi_masalah,
               aduan->adu_tempat[i].status);
    }
}

void tampilkanPengaduanFasilitas(struct Aduan *aduan) {
    printf("\nDaftar Pengaduan Fasilitas:\n");
    for (int i = 0; i < aduan->count_fasilitas; i++) {
        printf("ID: %d, Nama: %s, No Telepon: %s, Tanggal Menginap: %s, Tanggal Melaporkan: %s, Tempat Kerusakan: %s, Jenis Masalah: %s, Deskripsi: %s, Kategori: %s, Status: %s\n",
               aduan->adu_fasilitas[i].id_pengaduan,
               aduan->adu_fasilitas[i].nama_pengadu,
               aduan->adu_fasilitas[i].no_telepon_pengadu,
               aduan->adu_fasilitas[i].tanggal_menginap,
               aduan->adu_fasilitas[i].tanggal_melaporkan,
               aduan->adu_fasilitas[i].tempat_kerusakan,
               aduan->adu_fasilitas[i].jenis_masalah,
               aduan->adu_fasilitas[i].deskripsi_masalah,
               aduan->adu_fasilitas[i].kategori_fasilitas,
               aduan->adu_fasilitas[i].status);
    }
}

void tampilkanPengaduanKinerja(struct Aduan *aduan) {
    printf("\nDaftar Pengaduan Kinerja:\n");
    for (int i = 0; i < aduan->count_kinerja; i++) {
        printf("ID: %d, Nama: %s, No Telepon: %s, Tanggal Menginap: %s, ID Pegawai: %d, Nama Pegawai: %s, Jabatan: %s, Waktu Kejadian: %s, Jenis Masalah: %s, Deskripsi: %s, Status: %s\n",
               aduan->adu_kinerja[i].id_pengaduan,
               aduan->adu_kinerja[i].nama_pengadu,
               aduan->adu_kinerja[i].no_telepon_pengadu,
               aduan->adu_kinerja[i].tanggal_menginap,
               aduan->adu_kinerja[i].id_pegawai,
               aduan->adu_kinerja[i].nama_pegawai,
               aduan->adu_kinerja[i].jabatan_pegawai,
               aduan->adu_kinerja[i].waktu_kejadian,
               aduan->adu_kinerja[i].jenis_masalah,
               aduan->adu_kinerja[i].deskripsi_masalah,
               aduan->adu_kinerja[i].status);
    }
}

void inisialisasiPengaduan(struct Aduan *aduan) {
    aduan->count_tempat = 1;
    aduan->count_fasilitas = 1;
    aduan->count_kinerja = 1;

    // Pengaduan tempat
    aduan->adu_tempat[0] = (struct DataAduTempat){1, "Filya", "0800000111", "2024-09-04", "10A", "Perawatan yang Kurang", "Kolam renangnya warna ijo", "2024-09-21 16:14:54", "upload.img", ""};

    // Pengaduan fasilitas
    aduan->adu_fasilitas[0] = (struct DataAduFasilitas){1, "Filya", "0800000111", "2024-09-04", "2024-09-21", "Kamar", "Wastafel", "Wastafel macet brooo", "Kualitas fasilitas buruk", ""};

    // Pengaduan kinerja
    aduan->adu_kinerja[0] = (struct DataAduKinerja){1, "Filya", "0800000111", "2024-09-04", 1, "Budi", "House Keeper", "2024-09-04 16:18:35", "Pelayanan Tidak Memuaskan", "Jutek banget namanya Budi", "upload.img", ""};
}

int main() {
    struct DataAdmin admin = {EMAIL_ADMIN, PASSWORD_ADMIN, NO_TELP_ADMIN};
    struct Aduan aduan;

    inisialisasiPengaduan(&aduan);
    login(admin);

    int pilihan;
    do {
        printf("\nMenu:\n");
        printf("1. Tampilkan Pengaduan Tempat\n");
        printf("2. Tampilkan Pengaduan Fasilitas\n");
        printf("3. Tampilkan Pengaduan Kinerja\n");
        printf("4. Beri Status Pengaduan Tempat\n");
        printf("5. Beri Status Pengaduan Fasilitas\n");
        printf("6. Beri Status Pengaduan Kinerja\n");
        printf("0. Keluar\n");
        printf("Pilih: ");
        scanf("%d", &pilihan);

        switch (pilihan) {
            case 1:
                tampilkanPengaduanTempat(&aduan);
                break;
            case 2:
                tampilkanPengaduanFasilitas(&aduan);
                break;
            case 3:
                tampilkanPengaduanKinerja(&aduan);
                break;
            case 4:
                beriStatusPengaduanTempat(&aduan);
                break;
            case 5:
                beriStatusPengaduanFasilitas(&aduan);
                break;
            case 6:
                beriStatusPengaduanKinerja(&aduan);
                break;
            case 0:
                printf("Selamat datang di halaman login!\n");
                break;
            default:
                printf("Pilihan tidak valid!\n");
                break;
        }
    } while (pilihan != 0);

    return 0;
}

