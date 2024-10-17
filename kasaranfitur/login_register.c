#include<stdio.h>
#include<string.h>

// Struktur data utk menyimpan informasi pengguna tamu villa
typedef struct 
{
    char email[50];
    char noTelp[20];
    char alamat[50];
    char password[50];
}User; // ditaruh dibawah agar bisa di panggil
User users[10];
int userCount = 0; /* inisialisasi dimulai dari 0 dan bertambah nilainya jika nanti ada user regis krn ada fungsi
                    fungsi userCount++ sebagai menambahkan nilai userCount */

// Struktur data utk menyimpan data pegawai
typedef struct 
{
    char email[50];
    char noTelp[20];
    char password[50];
}DataPegawai; // ditaruh dibawah agar bisa di panggil

//data pegawai
DataPegawai dataPegawai[5] = {
    {"filyaSuite@email.com", "123456", "FilyaSuite"},
    {"admin1@email.com", "7890123", "admin123"},
    {"admin2@email.com", "456789352", "admin456"},
};
int pegawaiCount = 3; /*jumlah data yang tersimpan di dataPegawai dan digunakan untuk looping pencarian
                        dataPegawai pada fungsi login()*/

/*deklarasi fungsi agar tidak tertunda ketika
memerulkan fungsi yang kodenya berada dibawah
pada fungsi yang kodenya diatas*/
void regis();
void login();
void loginGuest();

//fungsi regis
void regis(){
    printf("Pantau Lapporanmu?\n");
    printf("Filya Suite siap membantu\n");
    printf("Enter Your Email: ");
    scanf("%s", users[userCount].email); // fungsi userCount untuk menyimpan secara looping
    printf("Enter Your Phone Number: ");
    scanf("%s", users[userCount].noTelp);
    printf("Enter Your Address: ");
    scanf(" %[^\n]%*c", users[userCount].alamat);
    printf("Enter Your Password: ");
    scanf("%s", users[userCount].password);
    userCount++; // menambah jumlah user stlh regis brhsl
    printf("Registrasi berhasil!\n\n");
    login(); // ketika regis selesai maka user lgsg diarahkan ke login
}

// fungsi login
void login(){
    char id[50], password[25];
    int found = 0; // inisiasi akun cocok dengan data register
    printf("Email / Phone Number : ");
    scanf("%s", id);

// jika user input 1 maka diarahkan ke fungsi regis
// jika user input 2 maka diarahkan ke fungsi login as guest
    if (strcmp(id, "1") == 0)
    {
        regis();
        return;
    }
    else if (strcmp(id, "2" ) == 0)
    {
        loginGuest();
        return;
    }
    
    // fungsi untuk menyimpan inputan password dari user
    printf("Password: ");
    scanf("%s", password);

// perulangan untuk mencari data pegawai
    for (int i = 0; i < pegawaiCount; i++)
    {
        if (strcmp(id, dataPegawai[i].email) == 0 || strcmp(id, dataPegawai[i].noTelp) == 0
            && strcmp(password, dataPegawai[i].password) == 0)
        {
            printf("=== Halo Admin ===\n\n");
            printf("Data Pegawai\n");
            printf("Data Kamar\n");
            printf("Data Kinerja\n");
            printf("Data Laaoran\n\n");
            printf("Ketersediaan kamar\n");
            printf("Kinerja\n");
            printf("Pegawai\n");
            printf("Fasilitas\n");
            return;
        }
        // fungsi if yaitu jika cocok antara inputan dengan data pegawai maka program diatas jalan
    }
    
// perulangan untuk mencari data pelanggan villa
    for (int i = 0; i < userCount; i++)
    {
        if ((strcmp(id, users[i].email) == 0 || strcmp(id, users[i].noTelp) == 0)
            && strcmp(password, users[i].password) == 0)
        {
            found = 1;
            break;
        }
        // fungsi if yaitu jika cocok antara inputan dengan data pegawai maka program if found jalan
    }

    // fungsi if jika data inputan dari user cocok dengan data pelanggan villa
    if (found)
    {
        char choice;
        printf("===Selamat Datang Di Filya Suite===\n\n");
        printf("a. Booking villa\n");
        printf("b. adu laporan terkait villa\n\n");
        scanf(" %c", &choice);
        if (choice == 'a')
        {
            printf("Halaman Booking Villa\n\n");
            printf("Cek Riwayat Booking villa atau cek tiket penginapan villa anda\n\n");
        }
        else if (choice == 'b')
        {
            printf("Adukan Jenis Laporan Anda\n");
            printf("1. Laporan Tempat\n");
            printf("2. Laporan Kinerja Pegawai\n");
            printf("3. Laporan Fasilitas\n");
            printf("Pantau Laporan Anda\n");
        }
    }

    // fungsi jika tidak ditemukan antara data pegawai atau data pelanggan villa
    else
    {
        printf("akun yang anda masukkan tidak terdaftar silahkan masukkan akun dengan benar\n");
        login();
    }
}

// Fungsi Login Sebagai Tamu
void loginGuest(){
    printf("Selamat datang di Halaman Laporan Pengaduan\n");
    printf("Adukan Jenis Laporan Anda\n");
    printf("1. Laporan Tempat\n");
    printf("2. Laporan Kinerja Pegawai\n");
    printf("3. Laporan Fasilitas\n\n\n");
    printf("Anda Login Sebagai Tamu\n");
}

int main(int argc, char const *argv[])
{
    printf("Jadilah bagian penyempurnaan FilyaSuite\n");
    printf("Don't have an account? Create an account by sending the message text '1'\n");
    printf("Login as Guest, sending the message text '2'\n");
    login();  
    return 0;
}
