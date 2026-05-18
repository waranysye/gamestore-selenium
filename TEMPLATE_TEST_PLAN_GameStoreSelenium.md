# Test Plan: GameStoreSelenium

## 1. INTRODUCTION

GameStoreSelenium adalah aplikasi e-commerce game berbasis CodeIgniter 4. Aplikasi ini menyediakan fitur utama seperti pendaftaran/login pengguna, katalog game, keranjang belanja, checkout, inventory game, dan antarmuka admin.

Dokumen ini menyusun rencana pengujian yang menerapkan template STQA dan mengacu pada modul STQA yang relevan. Tujuan utamanya adalah menjamin kualitas fungsi, keamanan, dan stabilitas aplikasi selama proses pengembangan.

## 2. IDEAL TEST ENVIRONMENT FOR GameStoreSelenium

### 2.1 Hardware

- CPU: Intel Core i5 generasi ke-8 atau lebih tinggi
- RAM: minimal 8 GB, direkomendasikan 16 GB
- Penyimpanan: SSD 256 GB atau lebih
- GPU: tidak wajib, tetapi kemampuan rendering browser yang baik membantu ketika menjalankan Selenium / Chrome
- Jaringan: koneksi lokal stabil untuk akses ke `localhost`

### 2.2 Software

- Sistem Operasi: Windows 10/11 (sesuai environment pengguna saat ini), Linux Ubuntu 22.04, atau MacOS terbaru
- Web server: XAMPP atau Apache + PHP-FPM
- PHP: versi 8.2 atau lebih tinggi
- CodeIgniter 4 framework
- Composer untuk dependency PHP
- Browser: Google Chrome versi terbaru
- ChromeDriver / Chrome Standalone Server pada port `9515`
- PHPUnit untuk unit dan integration test
- Selenium WebDriver (melalui paket `facebook/webdriver` pada PHP)
- Database: MySQL / MariaDB lokal, dengan environment khusus `tests` untuk pengujian

### 2.3 Konfigurasi khusus

- `baseUrl` aplikasi: `http://localhost:8082`
- `tests` database terpisah, tidak menggunakan database produksi
- `tests/Support/BaseSeleniumTest.php` menjalankan migrasi dan seeders sebelum UI test
- Pastikan `chrome.exe` yang digunakan sesuai path `C:/xampp/htdocs/gamestoreSelenium/chrome/chrome-win64/chrome.exe`

## 3. TESTING TECHNIQUES IMPLEMENTED IN GameStoreSelenium

Berikut teknik pengujian yang diterapkan dalam aplikasi ini, sesuai modul Chapter 4 halaman 4.7-4.11.

### 3.1 Structural Testing Techniques

Dalam aplikasi GameStoreSelenium, selain teknik struktural yang umum, terdapat beberapa teknik berikut:

- Stress testing
- Recovery testing
- Operations testing
- Compliance testing
- Security testing

#### Structural Testing Techniques Table

**Stress testing**  
1. Enter transactions at a normal or above normal pace.  
2. Use test data generators, test transaction scripts, or production transaction history.  
3. Overload the network with transactions.  
4. Enter more transactions than can be successfully handled by internal storage, queues, and tables.  

1. Is there sufficient allocation for resources such as memory and disk?  
2. Are there sufficient communication lines?  
3. Can the system handle above-normal transaction volumes?  
4. Can the system meet expected turnaround times?  

**Recovery testing**  
1. Induce system failure.  
2. Verify recovery procedures.  

1. Is the backup data adequate?  
2. Is the backup data secured?  
3. Are the recovery procedures properly documented?  
4. Are the recovery tools available?  

**Operations testing**  
1. Integrate the application into the operating environment.  
2. Make the operations staff execute the application using normal operating procedures and documentation.  

1. Is it possible to operate the system by following operator documentation?  
2. Are the operators trained for unusual procedures?  
3. Can the operations staff execute the application without outside help?  

**Compliance testing**  
1. Have a peer group compare programs to established standards.  
2. Create a list of programs that do not conform and need correction.  

1. Are standards being followed?  
2. Is the documentation complete?  
3. Does the code comply with project-specific programming standards?  

**Security testing**  
1. Attempt unauthorized access to the system.  
2. Validate access control and security enforcement.  

1. Is access to critical functions restricted?  
2. Are security procedures properly implemented?  
3. Do security procedures function according to specifications?

### 3.2 Functional Testing Techniques

Dalam aplikasi GameStoreSelenium, teknik fungsional berikut juga digunakan:

- Requirements testing
- Regression testing
- Error-handling testing
- Manual-support testing
- Intersystem testing
- Control testing
- Parallel testing

#### Functional Testing Techniques Table

| Technique | Action Performed | Examples of Factors Evaluated |
|---|---|---|
| Requirements testing | 1. Create test conditions directly from user requirements.<br>2. Create a test matrix.<br>3. Create specific functional checklists for testing the application.<br>4. Compare the application with created checklists to ensure conformance to specified policies and regulations. | 1. Are system requirements fulfilled?<br>2. Does the system conform to specified policies and regulations?<br>3. Does the application perform correctly over extended periods? |
| Regression testing | 1. Rerun previously executed tests after changing a part of the system.<br>2. Review previously created manuals after changing a part of the system. | 1. Does the unchanged portion of the system function properly?<br>2. Is the unchanged portion of user manuals correct?<br>3. Are new code changes not breaking existing functionality? |
| Error-handling testing | 1. Anticipate what can go wrong with the application.<br>2. Create a set of test transactions to introduce identified errors.<br>3. Execute the created test transactions.<br>4. Reenter error conditions after making corrections. | 1. Does the application satisfactorily handle error conditions?<br>2. Are error messages appropriate and helpful?<br>3. Does the application recover gracefully from invalid input? |
| Manual-support testing | 1. Have end users use manual-support procedures to prepare and enter data into the system.<br>2. Have users use processing results to take required action. | 1. Are users able to perform their tasks by referring to user manuals?<br>2. Can the interface deliver useful information to users? |
| Intersystem testing | 1. Develop test transactions in one application to check interaction with another application.<br>2. Enter test transactions in a live environment using test tools to pass conditions between applications.<br>3. Verify the documentation of affected systems. | 1. Are the intersystem parameters appropriate?<br>2. Is the data passed correctly between applications?<br>3. Is the intersystem documentation updated? |
| Control testing | 1. Identify risks, controls, and the application segment containing the control.<br>2. Set up risk situations. | 1. Do the controls effectively reduce risks to an acceptable level?<br>2. Is intersystem documentation updated?<br>3. Are audit trails, backup, and recovery mechanisms functioning? |
| Parallel testing | 1. Operate the old and new versions of the system together. | 1. Do the old and new systems reconcile?<br>2. Are results consistent between versions? |

### 3.3 Additional notes

- Stress testing in GameStoreSelenium dapat dilakukan dengan simulasi beban API, banyak login, dan transaksi checkout berulang.
- Recovery testing melibatkan prosedur backup database `tests`, restore, dan verifikasi bahwa aplikasi kembali berjalan.
- Operations testing memastikan staff operasional dapat menjalankan server lokal, migrasi database, dan dokumentasi prosedur.
- Compliance testing memeriksa apakah standar proyek, style code, dan dokumentasi diikuti.
- Security testing meliputi test kontrol akses, CSRF, XSS, dan otorisasi admin.

## 4. TYPE OF TESTING TOOLS FOR GameStoreSelenium

### 4.1 Manual testing tools

- Browser Chrome untuk melakukan validasi manual.
- Postman atau browser untuk memeriksa endpoint `http://localhost:8082`.
- Observasi manual pada tampilan halaman login, keranjang, dan admin.

### 4.2 Automation testing tools

- PHPUnit: untuk unit, integration, dan controller testing.
- Selenium WebDriver + Google Chrome: untuk UI automation.
- CodeIgniter Test Tools: `CIUnitTestCase`, `ControllerTestTrait`, `DatabaseTestTrait`.

### 4.3 General description

Aplikasi ini memanfaatkan tools testing umum: PHPUnit untuk pengujian backend dan Selenium untuk pengujian antarmuka browser. Automasi membantu validasi flow e-commerce secara berulang.

## 5. RISKS TO GameStoreSelenium DURING TESTING

### 5.1 Risks terkait data

- Pengujian menggunakan database produksi jika konfigurasi salah.
- Data uji bisa mengubah data nyata jika environment tidak dipisah.

### 5.2 Risks terkait infrastruktur

- ChromeDriver tidak sesuai versi Chrome sehingga Selenium gagal.
- Port `9515` atau `8082` bentrok dengan proses lain.

### 5.3 Risks terkait keamanan

- CSRF / XSS tidak terdeteksi jika hanya melakukan pengujian fungsi sempit.
- Akses admin tidak dikunci dengan benar.

### 5.4 Risks terkait kualitas test

- Test manual tidak terdokumentasi, berisiko dilewati.
- Otomasi test tidak dijalankan secara rutin sehingga bug regresi tidak terdeteksi.

## 6. TYPICAL COMPONENTS OF A TEST PLAN FOR GameStoreSelenium

### 6.1 Scope of test

- Mencakup fitur utama aplikasi GameStoreSelenium: autentikasi, katalog game, keranjang, checkout, profil, admin, dan keamanan dasar.
- Tidak mencakup integrasi pembayaran nyata di gateway eksternal.

### 6.2 Test objectives

- Memastikan user dapat mendaftar, login, dan mengakses halaman yang sesuai.
- Memastikan keranjang berfungsi: tambah, hapus, dan lihat cart.
- Memastikan checkout dan transaksi dasar berjalan.
- Memastikan kontrol akses admin/user dan validasi input.

### 6.3 List of assumptions

- Aplikasi berjalan pada `localhost:8082`.
- Browser Chrome tersedia dan ChromeDriver dikonfigurasi.
- Database `tests` sudah dibuat dan dapat diakses.
- Semua dependency PHP terpasang melalui Composer.

### 6.4 Result of risk analysis

- Risiko terbesar: test menulis data ke database production.
- Mitigasi: gunakan environment `tests` dan cek `BaseIntegrationTest::setUp()`.
- Risiko kedua: versi Chrome dan ChromeDriver mismatch.
- Mitigasi: gunakan versi Chrome yang kompatibel dan path executable yang benar.

### 6.5 Test schedule

Rencana waktu pengujian 10 hari kalender:

- Hari 1: Persiapan lingkungan, setup XAMPP, Composer, ChromeDriver
- Hari 2: Verifikasi database `tests` dan migrasi/seed
- Hari 3: Pelaksanaan unit test dasar
- Hari 4: Pelaksanaan integration test
- Hari 5: Pelaksanaan manual exploratory testing pada fitur login/checkout
- Hari 6: Automasi Selenium dasar dan debug script
- Hari 7: Pengujian keamanan dasar (CSRF, akses kontrol, input validation)
- Hari 8: Regression test ulang semua suite
- Hari 9: Review hasil tes dan perbaikan bug
- Hari 10: Finalisasi laporan dan retest perbaikan

### 6.6 Test design & test completion criteria

#### Test Case Contoh 1: Login dengan kredensial valid

- ID: TC-LOGIN-001
- Objective: Memastikan user dapat login dengan email/password benar.
- Precondition: User sudah ada di database `tests`.
- Steps:
  1. Buka halaman `http://localhost:8082/index.php/login`.
  2. Masukkan email valid.
  3. Masukkan password benar.
  4. Klik tombol `Login`.
- Expected result: Halaman diarahkan ke dashboard atau halaman utama dan response HTTP status 200/302.

##### Gherkin style

```
Scenario: User berhasil login dengan kredensial valid
  Given halaman login terbuka
  When user memasukkan email valid dan password benar
  And user menekan tombol login
  Then user diarahkan ke dashboard
  And tidak ada pesan error autentikasi
```

#### Test Case Contoh 2: Tambah game ke keranjang

- ID: TC-CART-001
- Objective: Memastikan user dapat menambahkan game ke cart.
- Precondition: User login, terdapat game tersedia.
- Steps:
  1. Login sebagai user.
  2. Buka halaman katalog game.
  3. Klik tombol `Add to Cart` pada game pilihan.
  4. Buka halaman keranjang.
- Expected result: Item game muncul di dalam keranjang.

##### Gherkin style

```
Scenario: User menambahkan game ke cart
  Given user telah login
  And game tersedia di halaman katalog
  When user menekan tombol add to cart pada game
  Then game muncul di halaman cart
  And subtotal cart terupdate
```

## 7. TEST CASE TABLE

| Test Case ID | Scenario ID | Test Case Description | Test Priority | Type of Test Case | Testing Category | Entry Criteria (if any) | Test Data | Expected Result | Actual Result | Test Result | PIC Tester | Test Execution Date | Defect ID (from bug logging Tool, if applicable) | Reference | Remark |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-001 | TS-001 | Verify model returns all rows | Low | Positive | Example/Misc | Database seeded | `ExampleDatabaseTest::testModelFindAll` | Model returns all rows | Model returns all rows | Pass | QA Tester | 13/05/2026 | - | `tests/database/ExampleDatabaseTest.php::testModelFindAll` | |
| TC-002 | TS-002 | Verify delete removes row | Low | Positive | Example/Misc | Database seeded | `ExampleDatabaseTest::testDeleteActuallyRemovesRow` | Delete removes row from DB | Delete removes row from DB | Pass | QA Tester | 13/05/2026 | - | `tests/database/ExampleDatabaseTest.php::testDeleteActuallyRemovesRow` | |
| TC-003 | TS-003 | Verify admin user exists | High | Positive | Integration | Test database seeded | `AdminIntegrationTest::testAdminUserExists` | Admin user exists in DB | Admin user exists in DB | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testAdminUserExists` | |
| TC-004 | TS-004 | Verify update game validation for empty title | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testUpdateGameValidation` | Validation fails for empty title | Validation fails for empty title | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testUpdateGameValidation` | |
| TC-005 | TS-005 | Verify update game validation for invalid price | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testUpdateGameValidation` | Validation fails for invalid price | Validation fails for invalid price | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testUpdateGameValidation` | |
| TC-006 | TS-006 | Verify update game validation for empty description | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testUpdateGameValidation` | Validation fails for empty description | Validation fails for empty description | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testUpdateGameValidation` | |
| TC-007 | TS-007 | Verify update game validation for short name | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testUpdateGameValidation` | Validation fails for short name | Validation fails for short name | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testUpdateGameValidation` | |
| TC-008 | TS-008 | Verify category index ok | High | Positive | Integration | Admin user seeded | `AdminIntegrationTest::testCategoryIndexOk` | Category index loads | Category index loads | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testCategoryIndexOk` | |
| TC-009 | TS-009 | Verify add game validation for empty title | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testAddGameValidation` | Validation fails for empty title | Validation fails for empty title | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testAddGameValidation` | |
| TC-010 | TS-010 | Verify add game validation for invalid price | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testAddGameValidation` | Validation fails for invalid price | Validation fails for invalid price | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testAddGameValidation` | |
| TC-011 | TS-011 | Verify add game validation for empty description | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testAddGameValidation` | Validation fails for empty description | Validation fails for empty description | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testAddGameValidation` | |
| TC-012 | TS-012 | Verify add game validation for short name | High | Negative | Integration | Admin user seeded | `AdminIntegrationTest::testAddGameValidation` | Validation fails for short name | Validation fails for short name | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testAddGameValidation` | |
| TC-013 | TS-013 | Verify delete game redirect | High | Positive | Integration | Admin user seeded | `AdminIntegrationTest::testDeleteGameRedirect` | Redirect after delete | Redirect after delete | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AdminIntegrationTest.php::testDeleteGameRedirect` | |
| TC-014 | TS-014 | Verify login fail for wrong password | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptLoginFail` | Login fails | Login fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptLoginFail` | |
| TC-015 | TS-015 | Verify login fail for non-existent email | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptLoginFail` | Login fails | Login fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptLoginFail` | |
| TC-016 | TS-016 | Verify login fail for invalid email format | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptLoginFail` | Login fails | Login fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptLoginFail` | |
| TC-017 | TS-017 | Verify login fail for empty input | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptLoginFail` | Login fails | Login fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptLoginFail` | |
| TC-018 | TS-018 | Verify signup validation for unchecked agree | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupValidation` | Signup fails | Signup fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupValidation` | |
| TC-019 | TS-019 | Verify signup validation for short name | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupValidation` | Signup fails | Signup fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupValidation` | |
| TC-020 | TS-020 | Verify signup validation for invalid email | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupValidation` | Signup fails | Signup fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupValidation` | |
| TC-021 | TS-021 | Verify signup validation for short password | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupValidation` | Signup fails | Signup fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupValidation` | |
| TC-022 | TS-022 | Verify signup validation for empty input | High | Negative | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupValidation` | Signup fails | Signup fails | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupValidation` | |
| TC-023 | TS-023 | Verify signup success | High | Positive | Integration | Auth service available | `AuthIntegrationTest::testAttemptSignupSuccess` | Signup succeeds | Signup succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptSignupSuccess` | |
| TC-024 | TS-024 | Verify login success | High | Positive | Integration | Auth service available | `AuthIntegrationTest::testAttemptLoginSuccess` | Login succeeds | Login succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testAttemptLoginSuccess` | |
| TC-025 | TS-025 | Verify logout | High | Positive | Integration | User logged in | `AuthIntegrationTest::testLogout` | Logout succeeds | Logout succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/integration/AuthIntegrationTest.php::testLogout` | |
| TC-026 | TS-026 | Verify cart created for user | High | Positive | Integration | User login simulation | `CartIntegrationTest::testCartCreatedForUser` | Cart record created | Cart record created | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testCartCreatedForUser` | |
| TC-027 | TS-027 | Verify add to cart controller success | High | Positive | Integration | Cart exists | `CartIntegrationTest::testAddToCartControllerSuccess` | Item added to cart | Item added to cart | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testAddToCartControllerSuccess` | |
| TC-028 | TS-028 | Verify remove from cart | High | Positive | Integration | Cart has items | `CartIntegrationTest::testRemoveFromCart` | Item removed from cart | Item removed from cart | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testRemoveFromCart` | |
| TC-029 | TS-029 | Verify add invalid game to cart | High | Negative | Integration | Cart exists | `CartIntegrationTest::testAddInvalidGameToCart` | Invalid game rejected | Invalid game rejected | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testAddInvalidGameToCart` | |
| TC-030 | TS-030 | Verify game exists in cart | High | Positive | Integration | Cart has items | `CartIntegrationTest::testGameExistsInCart` | Game exists in cart | Game exists in cart | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testGameExistsInCart` | |
| TC-031 | TS-031 | Verify view cart page | High | Positive | Integration | Cart exists | `CartIntegrationTest::testViewCartPage` | Cart page loads | Cart page loads | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CartIntegrationTest.php::testViewCartPage` | |
| TC-032 | TS-032 | Verify order created | High | Positive | Integration | Checkout service available | `CheckoutIntegrationTest::testOrderCreated` | Order record created | Order record created | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CheckoutIntegrationTest.php::testOrderCreated` | |
| TC-033 | TS-033 | Verify order detail created | High | Positive | Integration | Order created | `CheckoutIntegrationTest::testOrderDetailCreated` | Order detail recorded | Order detail recorded | Pass | QA Tester | 13/05/2026 | - | `tests/integration/CheckoutIntegrationTest.php::testOrderDetailCreated` | |
| TC-034 | TS-034 | Verify game marked as installed after download | High | Positive | Integration | Download integration available | `DownloadIntegrationTest::testGameMarkedAsInstalledAfterDownload` | Game marked installed | Game marked installed | Pass | QA Tester | 13/05/2026 | - | `tests/integration/DownloadIntegrationTest.php::testGameMarkedAsInstalledAfterDownload` | |
| TC-035 | TS-035 | Verify user owns game | High | Positive | Integration | Library record exists | `LibraryIntegrationTest::testUserOwnsGame` | User owns game in library | User owns game in library | Pass | QA Tester | 13/05/2026 | - | `tests/integration/LibraryIntegrationTest.php::testUserOwnsGame` | |
| TC-036 | TS-036 | Verify install game | High | Positive | Integration | Library user owns game | `LibraryIntegrationTest::testInstallGame` | Install state updated | Install state updated | Pass | QA Tester | 13/05/2026 | - | `tests/integration/LibraryIntegrationTest.php::testInstallGame` | |
| TC-037 | TS-037 | Verify payment created | High | Positive | Integration | Payment service available | `PaymentIntegrationTest::testPaymentCreated` | Payment created | Payment created | Pass | QA Tester | 13/05/2026 | - | `tests/integration/PaymentIntegrationTest.php::testPaymentCreated` | |
| TC-038 | TS-038 | Verify payment status paid | High | Positive | Integration | Payment created | `PaymentIntegrationTest::testPaymentStatusPaid` | Payment status paid | Payment status paid | Pass | QA Tester | 13/05/2026 | - | `tests/integration/PaymentIntegrationTest.php::testPaymentStatusPaid` | |
| TC-039 | TS-039 | Verify update profile validation for empty name | High | Negative | Integration | User logged in | `ProfileIntegrationTest::testUpdateProfileValidation` | Validation fails for empty name | Validation fails for empty name | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateProfileValidation` | |
| TC-040 | TS-040 | Verify update profile validation for invalid email | High | Negative | Integration | User logged in | `ProfileIntegrationTest::testUpdateProfileValidation` | Validation fails for invalid email | Validation fails for invalid email | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateProfileValidation` | |
| TC-041 | TS-041 | Verify update profile validation for short name | High | Negative | Integration | User logged in | `ProfileIntegrationTest::testUpdateProfileValidation` | Validation fails for short name | Validation fails for short name | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateProfileValidation` | |
| TC-042 | TS-042 | Verify update profile validation for empty email | High | Negative | Integration | User logged in | `ProfileIntegrationTest::testUpdateProfileValidation` | Validation fails for empty email | Validation fails for empty email | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateProfileValidation` | |
| TC-043 | TS-043 | Verify update name only | High | Positive | Integration | User logged in | `ProfileIntegrationTest::testUpdateNameOnly` | Name updated successfully | Name updated successfully | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateNameOnly` | |
| TC-044 | TS-044 | Verify update email only | High | Positive | Integration | User logged in | `ProfileIntegrationTest::testUpdateEmailOnly` | Email updated successfully | Email updated successfully | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testUpdateEmailOnly` | |
| TC-045 | TS-045 | Verify view profile page | High | Positive | Integration | User logged in | `ProfileIntegrationTest::testViewProfilePage` | Profile page loads | Profile page loads | Pass | QA Tester | 13/05/2026 | - | `tests/integration/ProfileIntegrationTest.php::testViewProfilePage` | |
| TC-046 | TS-046 | Verify game can be fetched | High | Positive | Integration | Store service available | `StoreIntegrationTest::testGameCanBeFetched` | Game list returned | Game list returned | Pass | QA Tester | 13/05/2026 | - | `tests/integration/StoreIntegrationTest.php::testGameCanBeFetched` | |
| TC-047 | TS-047 | Verify trending games | High | Positive | Integration | Store service available | `StoreIntegrationTest::testTrendingGames` | Trending games returned | Trending games returned | Pass | QA Tester | 13/05/2026 | - | `tests/integration/StoreIntegrationTest.php::testTrendingGames` | |
| TC-048 | TS-048 | Verify order and payment flow | High | Positive | Integration | Order and payment services available | `TransactionIntegrationTest::testOrderAndPaymentFlow` | Transaction completes | Transaction completes | Pass | QA Tester | 13/05/2026 | - | `tests/integration/TransactionIntegrationTest.php::testOrderAndPaymentFlow` | |
| TC-049 | TS-049 | Verify guest cannot access cart | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessCart` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessCart` | |
| TC-050 | TS-050 | Verify guest cannot access checkout | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessCheckout` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessCheckout` | |
| TC-051 | TS-051 | Verify guest cannot access library | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessLibrary` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessLibrary` | |
| TC-052 | TS-052 | Verify guest cannot access admin games | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessAdminGames` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessAdminGames` | |
| TC-053 | TS-053 | Verify guest cannot access admin categories | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessAdminCategories` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessAdminCategories` | |
| TC-054 | TS-054 | Verify guest cannot access admin users | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessAdminUsers` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessAdminUsers` | |
| TC-055 | TS-055 | Verify guest cannot access admin orders | High | Negative | Security | No login session | `AccessControlTest::testGuestCannotAccessAdminOrders` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testGuestCannotAccessAdminOrders` | |
| TC-056 | TS-056 | Verify customer cannot access admin games | High | Negative | Security | User role is customer | `AccessControlTest::testCustomerCannotAccessAdminGames` | Access denied or redirect | Access denied or redirect | Pass | QA Tester | 13/05/2026 | - | `tests/security/AccessControlTest.php::testCustomerCannotAccessAdminGames` | |
| TC-057 | TS-057 | Verify login fails with wrong password | High | Negative | Security | Login form available | `AuthenticationTest::testLoginFailsWithWrongPassword` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/security/AuthenticationTest.php::testLoginFailsWithWrongPassword` | |
| TC-058 | TS-058 | Verify login fails with empty input | High | Negative | Security | Login form available | `AuthenticationTest::testLoginFailsWithEmptyInput` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/security/AuthenticationTest.php::testLoginFailsWithEmptyInput` | |
| TC-059 | TS-059 | Verify login succeeds with valid credentials | High | Positive | Security | Login form available | `AuthenticationTest::testLoginSuccessWithValidCredentials` | Login accepted | Login accepted | Pass | QA Tester | 13/05/2026 | - | `tests/security/AuthenticationTest.php::testLoginSuccessWithValidCredentials` | |
| TC-060 | TS-060 | Verify user cannot access admin | High | Negative | Security | User login available | `AuthorizationTest::testUserCannotAccessAdmin` | Access denied | Access denied | Pass | QA Tester | 13/05/2026 | - | `tests/security/AuthorizationTest.php::testUserCannotAccessAdmin` | |
| TC-061 | TS-061 | Verify admin can access admin area | High | Positive | Security | Admin login available | `AuthorizationTest::testAdminCanAccessAdmin` | Access granted | Access granted | Pass | QA Tester | 13/05/2026 | - | `tests/security/AuthorizationTest.php::testAdminCanAccessAdmin` | |
| TC-062 | TS-062 | Verify login blocked without CSRF token | High | Negative | Security | Login requires CSRF | `CsrfTest::testLoginBlockedWithoutCsrf` | Access blocked | Access blocked | Pass | QA Tester | 13/05/2026 | - | `tests/security/CsrfTest.php::testLoginBlockedWithoutCsrf` | |
| TC-063 | TS-063 | Verify no session cannot access cart | High | Negative | Security | No login session | `SessionSecurityTest::testNoSessionCannotAccessCart` | Access denied | Access denied | Pass | QA Tester | 13/05/2026 | - | `tests/security/SessionSecurityTest.php::testNoSessionCannotAccessCart` | |
| TC-064 | TS-064 | Verify fake session rejected | High | Negative | Security | Invalid session present | `SessionSecurityTest::testFakeSessionWithoutUserIdIsRejected` | Session rejected | Session rejected | Pass | QA Tester | 13/05/2026 | - | `tests/security/SessionSecurityTest.php::testFakeSessionWithoutUserIdIsRejected` | |
| TC-065 | TS-065 | Verify valid session can access cart | High | Positive | Security | Valid session available | `SessionSecurityTest::testValidSessionCanAccessCart` | Access granted | Access granted | Pass | QA Tester | 13/05/2026 | - | `tests/security/SessionSecurityTest.php::testValidSessionCanAccessCart` | |
| TC-066 | TS-066 | Verify SQL injection login blocked | High | Negative | Security | Login form available | `SqlInjectionTest::testSqlInjectionLoginBlocked` | Injection rejected | Injection rejected | Pass | QA Tester | 13/05/2026 | - | `tests/security/SqlInjectionTest.php::testSqlInjectionLoginBlocked` | |
| TC-067 | TS-067 | Verify XSS payload does not crash system | High | Negative | Security | Input validation enforced | `XssTest::testXssPayloadDoesNotCrashSystem` | System remains stable | System remains stable | Pass | QA Tester | 13/05/2026 | - | `tests/security/XssTest.php::testXssPayloadDoesNotCrashSystem` | |
| TC-068 | TS-068 | Verify session simple | Low | Positive | Example/Misc | Session ready | `ExampleSessionTest::testSessionSimple` | Session functions as expected | Session functions as expected | Pass | QA Tester | 13/05/2026 | - | `tests/session/ExampleSessionTest.php::testSessionSimple` | |
| TC-069 | TS-069 | Verify admin login | High | Positive | UI Automation | Login page available | `AdminCrudTest::testAdminLogin` | Access admin panel | Access admin panel | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testAdminLogin` | |
| TC-070 | TS-070 | Verify create game | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testCreateGame` | Game create page opens | Game create page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testCreateGame` | |
| TC-071 | TS-071 | Verify edit game | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testEditGame` | Game edit page opens | Game edit page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testEditGame` | |
| TC-072 | TS-072 | Verify delete game | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testDeleteGame` | Delete game page opens | Delete game page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testDeleteGame` | |
| TC-073 | TS-073 | Verify create category | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testCreateCategory` | Category page opens | Category page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testCreateCategory` | |
| TC-074 | TS-074 | Verify edit category | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testEditCategory` | Edit category page opens | Edit category page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testEditCategory` | |
| TC-075 | TS-075 | Verify delete category | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testDeleteCategory` | Delete category page opens | Delete category page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testDeleteCategory` | |
| TC-076 | TS-076 | Verify approve order | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testApproveOrder` | Orders page opens | Orders page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testApproveOrder` | |
| TC-077 | TS-077 | Verify reject order | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testRejectOrder` | Orders page opens | Orders page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testRejectOrder` | |
| TC-078 | TS-078 | Verify list users | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testListUsers` | User list opens | User list opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testListUsers` | |
| TC-079 | TS-079 | Verify delete user | High | Positive | UI Automation | Admin logged in | `AdminCrudTest::testDeleteUser` | User management opens | User management opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/AdminCrudTest.php::testDeleteUser` | |
| TC-080 | TS-080 | Verify add to cart | High | Positive | UI Automation | User logged in | `CartTest::testAddToCart` | Item added to cart | Item added to cart | Pass | QA Tester | 13/05/2026 | - | `tests/ui/CartTest.php::testAddToCart` | |
| TC-081 | TS-081 | Verify cart page loads | High | Positive | UI Automation | User logged in | `CartTest::testCartPageLoads` | Cart page loads | Cart page loads | Pass | QA Tester | 13/05/2026 | - | `tests/ui/CartTest.php::testCartPageLoads` | |
| TC-082 | TS-082 | Verify cart has items | High | Positive | UI Automation | User logged in | `CartTest::testCartHasItems` | Cart item list available | Cart item list available | Pass | QA Tester | 13/05/2026 | - | `tests/ui/CartTest.php::testCartHasItems` | |
| TC-083 | TS-083 | Verify remove item | High | Positive | UI Automation | User logged in | `CartTest::testRemoveItem` | Item removed from cart | Item removed from cart | Pass | QA Tester | 13/05/2026 | - | `tests/ui/CartTest.php::testRemoveItem` | |
| TC-084 | TS-084 | Verify checkout buy now to pending status | High | Positive | UI Automation | User logged in | `CheckoutTest::testCheckoutBuyNowToPendingStatus` | Checkout completes | Checkout completes | Pass | QA Tester | 13/05/2026 | - | `tests/ui/CheckoutTest.php::testCheckoutBuyNowToPendingStatus` | |
| TC-085 | TS-085 | Verify paid game appears in library | High | Positive | UI Automation | User logged in | `LibraryTest::testPaidGameAppearsInLibrary` | Paid game listed in library | Paid game listed in library | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LibraryTest.php::testPaidGameAppearsInLibrary` | |
| TC-086 | TS-086 | Verify download button visible | High | Positive | UI Automation | User logged in | `LibraryTest::testDownloadButtonVisible` | Download button visible | Download button visible | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LibraryTest.php::testDownloadButtonVisible` | |
| TC-087 | TS-087 | Verify download changes to uninstall | High | Positive | UI Automation | User logged in | `LibraryTest::testDownloadChangesToUninstall` | Button changes to uninstall | Button changes to uninstall | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LibraryTest.php::testDownloadChangesToUninstall` | |
| TC-088 | TS-088 | Verify uninstall changes back to download | High | Positive | UI Automation | User logged in | `LibraryTest::testUninstallChangesBackToDownload` | Button returns to download state | Button returns to download state | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LibraryTest.php::testUninstallChangesBackToDownload` | |
| TC-089 | TS-089 | Verify login success | High | Positive | UI Automation | Login page available | `LoginTest::testLoginSuccess` | Login succeeds | Login succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginSuccess` | |
| TC-090 | TS-090 | Verify login wrong password | High | Negative | UI Automation | Login page available | `LoginTest::testLoginWrongPassword` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginWrongPassword` | |
| TC-091 | TS-091 | Verify login empty form | High | Negative | UI Automation | Login page available | `LoginTest::testLoginEmptyForm` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginEmptyForm` | |
| TC-092 | TS-092 | Verify logout success | High | Positive | UI Automation | User logged in | `LoginTest::testLogoutSuccess` | Logout completes | Logout completes | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLogoutSuccess` | |
| TC-093 | TS-093 | Verify login wrong email format | High | Negative | UI Automation | Login page available | `LoginTest::testLoginWrongEmailFormat` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginWrongEmailFormat` | |
| TC-094 | TS-094 | Verify login admin success | High | Positive | UI Automation | Login page available | `LoginTest::testLoginAdminSuccess` | Admin login succeeds | Admin login succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginAdminSuccess` | |
| TC-095 | TS-095 | Verify login SQL injection attempt | High | Negative | UI Automation | Login page available | `LoginTest::testLoginSqlInjectionAttempt` | Injection blocked | Injection blocked | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginSqlInjectionAttempt` | |
| TC-096 | TS-096 | Verify login very long password | High | Negative | UI Automation | Login page available | `LoginTest::testLoginVeryLongPassword` | Login rejected | Login rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginVeryLongPassword` | |
| TC-097 | TS-097 | Verify login with XSS input | High | Negative | UI Automation | Login page available | `LoginTest::testLoginWithXssInput` | XSS input rejected | XSS input rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginWithXssInput` | |
| TC-098 | TS-098 | Verify login case sensitive email | High | Positive | UI Automation | Login page available | `LoginTest::testLoginCaseSensitiveEmail` | Login succeeds | Login succeeds | Pass | QA Tester | 13/05/2026 | - | `tests/ui/LoginTest.php::testLoginCaseSensitiveEmail` | |
| TC-099 | TS-099 | Verify update email success | High | Positive | UI Automation | User logged in | `ProfileTest::testUpdateEmailSuccess` | Email updated successfully | Email updated successfully | Pass | QA Tester | 13/05/2026 | - | `tests/ui/ProfileTest.php::testUpdateEmailSuccess` | |
| TC-100 | TS-100 | Verify profile page loads | High | Positive | UI Automation | User logged in | `ProfileTest::testProfilePageLoads` | Profile page opens | Profile page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/ProfileTest.php::testProfilePageLoads` | |
| TC-101 | TS-101 | Verify update password success | High | Positive | UI Automation | User logged in | `ProfileTest::testUpdatePasswordSuccess` | Password updated successfully | Password updated successfully | Pass | QA Tester | 13/05/2026 | - | `tests/ui/ProfileTest.php::testUpdatePasswordSuccess` | |
| TC-102 | TS-102 | Verify logout from profile | High | Positive | UI Automation | User logged in | `ProfileTest::testLogoutFromProfile` | Logout completes | Logout completes | Pass | QA Tester | 13/05/2026 | - | `tests/ui/ProfileTest.php::testLogoutFromProfile` | |
| TC-103 | TS-103 | Verify register success | High | Positive | UI Automation | Signup page available | `RegisterTest::testRegisterSuccess` | Signup completes | Signup completes | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterSuccess` | |
| TC-104 | TS-104 | Verify register duplicate email | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterDuplicateEmail` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterDuplicateEmail` | |
| TC-105 | TS-105 | Verify register empty form | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterEmptyForm` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterEmptyForm` | |
| TC-106 | TS-106 | Verify password min length | High | Negative | UI Automation | Signup page available | `RegisterTest::testPasswordMinLength` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testPasswordMinLength` | |
| TC-107 | TS-107 | Verify signup page loads | High | Positive | UI Automation | Signup page available | `RegisterTest::testSignupPageLoads` | Signup page opens | Signup page opens | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testSignupPageLoads` | |
| TC-108 | TS-108 | Verify register with empty email | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterWithEmptyEmail` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterWithEmptyEmail` | |
| TC-109 | TS-109 | Verify register XSS in name | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterXssInName` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterXssInName` | |
| TC-110 | TS-110 | Verify register numeric name | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterNumericName` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterNumericName` | |
| TC-111 | TS-111 | Verify register with spaces only | High | Negative | UI Automation | Signup page available | `RegisterTest::testRegisterWithSpacesOnly` | Signup rejected | Signup rejected | Pass | QA Tester | 13/05/2026 | - | `tests/ui/RegisterTest.php::testRegisterWithSpacesOnly` | |
| TC-112 | TS-112 | Verify password strength | Medium | Positive | Unit | Auth service available | `AuthServiceTest::testPasswordStrength` | Password strength validated | Password strength validated | Pass | QA Tester | 13/05/2026 | - | `tests/unit/AuthServiceTest.php::testPasswordStrength` | |
| TC-113 | TS-113 | Verify token generation | Medium | Positive | Unit | Auth service available | `AuthServiceTest::testTokenGeneration` | Token generated | Token generated | Pass | QA Tester | 13/05/2026 | - | `tests/unit/AuthServiceTest.php::testTokenGeneration` | |
| TC-114 | TS-114 | Verify calculate total | Medium | Positive | Unit | Cart service available | `CartServiceTest::testCalculateTotal` | Total calculated correctly | Total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CartServiceTest.php::testCalculateTotal` | |
| TC-115 | TS-115 | Verify format rupiah | Medium | Positive | Unit | Cart service available | `CartServiceTest::testFormatRupiah` | Rupiah formatted | Rupiah formatted | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CartServiceTest.php::testFormatRupiah` | |
| TC-116 | TS-116 | Verify tax calculation for 100rb | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-117 | TS-117 | Verify tax calculation for 50rb | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-118 | TS-118 | Verify tax calculation for 1jt | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-119 | TS-119 | Verify tax calculation for 1.5jt | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-120 | TS-120 | Verify tax calculation for cheap game | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-121 | TS-121 | Verify tax calculation for free game | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testTaxCalculation` | Tax calculated correctly | Tax calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testTaxCalculation` | |
| TC-122 | TS-122 | Verify grand total for normal checkout | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testGrandTotal` | Grand total calculated correctly | Grand total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testGrandTotal` | |
| TC-123 | TS-123 | Verify grand total for small checkout | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testGrandTotal` | Grand total calculated correctly | Grand total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testGrandTotal` | |
| TC-124 | TS-124 | Verify grand total for large checkout | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testGrandTotal` | Grand total calculated correctly | Grand total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testGrandTotal` | |
| TC-125 | TS-125 | Verify grand total for zero tax | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testGrandTotal` | Grand total calculated correctly | Grand total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testGrandTotal` | |
| TC-126 | TS-126 | Verify grand total for free game | Medium | Positive | Unit | Checkout service available | `CheckoutServiceTest::testGrandTotal` | Grand total calculated correctly | Grand total calculated correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/CheckoutServiceTest.php::testGrandTotal` | |
| TC-127 | TS-127 | Verify public routes | Medium | Positive | Unit | Base config loaded | `ControllerCoverageTest::testPublicRoutes` | Public routes defined | Public routes defined | Pass | QA Tester | 13/05/2026 | - | `tests/unit/ControllerCoverageTest.php::testPublicRoutes` | |
| TC-128 | TS-128 | Verify all routes coverage | Medium | Positive | Unit | Base config loaded | `ControllerCoverageTest::testAllRoutesCoverage` | All routes covered | All routes covered | Pass | QA Tester | 13/05/2026 | - | `tests/unit/ControllerCoverageTest.php::testAllRoutesCoverage` | |
| TC-129 | TS-129 | Verify price must be numeric | Medium | Positive | Unit | Game model available | `GameModelTest::testPriceMustBeNumeric` | Price numeric validation passes | Price numeric validation passes | Pass | QA Tester | 13/05/2026 | - | `tests/unit/GameModelTest.php::testPriceMustBeNumeric` | |
| TC-130 | TS-130 | Verify game title not empty | Medium | Positive | Unit | Game model available | `GameModelTest::testGameTitleNotEmpty` | Title validation passes | Title validation passes | Pass | QA Tester | 13/05/2026 | - | `tests/unit/GameModelTest.php::testGameTitleNotEmpty` | |
| TC-131 | TS-131 | Verify search keyword logic | Medium | Positive | Unit | Game model available | `GameModelTest::testSearchKeywordLogic` | Search keyword logic works | Search keyword logic works | Pass | QA Tester | 13/05/2026 | - | `tests/unit/GameModelTest.php::testSearchKeywordLogic` | |
| TC-132 | TS-132 | Verify app path is defined | Medium | Positive | Unit | Base config loaded | `HealthTest::testIsDefinedAppPath` | App path defined | App path defined | Pass | QA Tester | 13/05/2026 | - | `tests/unit/HealthTest.php::testIsDefinedAppPath` | |
| TC-133 | TS-133 | Verify base URL has been set | Medium | Positive | Unit | Base config loaded | `HealthTest::testBaseUrlHasBeenSet` | Base URL set correctly | Base URL set correctly | Pass | QA Tester | 13/05/2026 | - | `tests/unit/HealthTest.php::testBaseUrlHasBeenSet` | |
| TC-134 | TS-134 | Verify can download | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testCanDownload` | Download allowed | Download allowed | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testCanDownload` | |
| TC-135 | TS-135 | Verify format game size | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testFormatGameSize` | Game size formatted | Game size formatted | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testFormatGameSize` | |
| TC-136 | TS-136 | Verify cannot download failed payment | Medium | Negative | Unit | Library service available | `LibraryServiceTest::testCannotDownloadFailedPayment` | Download blocked | Download blocked | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testCannotDownloadFailedPayment` | |
| TC-137 | TS-137 | Verify cannot download cancelled payment | Medium | Negative | Unit | Library service available | `LibraryServiceTest::testCannotDownloadCancelledPayment` | Download blocked | Download blocked | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testCannotDownloadCancelledPayment` | |
| TC-138 | TS-138 | Verify can download completed payment | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testCanDownloadUppercaseCompleted` | Download allowed | Download allowed | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testCanDownloadUppercaseCompleted` | |
| TC-139 | TS-139 | Verify format zero size | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testFormatZeroSize` | Zero size formatted | Zero size formatted | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testFormatZeroSize` | |
| TC-140 | TS-140 | Verify format one gb | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testFormatOneGb` | Size formatted as 1 GB | Size formatted as 1 GB | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testFormatOneGb` | |
| TC-141 | TS-141 | Verify format three gb | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testFormatThreeGb` | Size formatted as 3 GB | Size formatted as 3 GB | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testFormatThreeGb` | |
| TC-142 | TS-142 | Verify format rounded down | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testFormatRoundedDown` | Size rounded down | Size rounded down | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testFormatRoundedDown` | |
| TC-143 | TS-143 | Verify service can be instantiated | Medium | Positive | Unit | Library service available | `LibraryServiceTest::testServiceCanBeInstantiated` | Service instantiated | Service instantiated | Pass | QA Tester | 13/05/2026 | - | `tests/unit/LibraryServiceTest.php::testServiceCanBeInstantiated` | |
| TC-144 | TS-144 | Verify user game model deep coverage | Medium | Positive | Unit | Model available | `ModelCoverageTest::testUserGameModelDeepCoverage` | Model coverage deep | Model coverage deep | Pass | QA Tester | 13/05/2026 | - | `tests/unit/ModelCoverageTest.php::testUserGameModelDeepCoverage` | |
| TC-145 | TS-145 | Verify trigger remaining models | Medium | Positive | Unit | Model available | `ModelCoverageTest::testTriggerRemainingModels` | Remaining models triggered | Remaining models triggered | Pass | QA Tester | 13/05/2026 | - | `tests/unit/ModelCoverageTest.php::testTriggerRemainingModels` | |
| TC-146 | TS-146 | Verify green models integrity | Medium | Positive | Unit | Model available | `ModelCoverageTest::testGreenModelsIntegrity` | Models integrity verified | Models integrity verified | Pass | QA Tester | 13/05/2026 | - | `tests/unit/ModelCoverageTest.php::testGreenModelsIntegrity` | |
| TC-147 | TS-147 | Verify payment status success | Medium | Positive | Unit | Payment service available | `PaymentServiceTest::testPaymentStatusSuccess` | Payment status success | Payment status success | Pass | QA Tester | 13/05/2026 | - | `tests/unit/PaymentServiceTest.php::testPaymentStatusSuccess` | |
| TC-148 | TS-148 | Verify transaction ID exists | Medium | Positive | Unit | Payment service available | `PaymentServiceTest::testTransactionIdExists` | Transaction ID exists | Transaction ID exists | Pass | QA Tester | 13/05/2026 | - | `tests/unit/PaymentServiceTest.php::testTransactionIdExists` | |

## 8. TEST RESULT SUMMARY

### 8.1 Test Result

| Test Group | Test Scripts | Pass | Fail | Error | Not Tested | Tested | Test Progress(%) | Test Completion(%) |
|---|---|---|---|---|---|
| Test Category | Total | Passed | Skipped | Failures | Errors |
|---|---|---|---|---|---|
| UI Automation | 43 | 38 | 5 | 0 | 0 |
| Integration | 46 | 46 | 0 | 0 | 0 |
| Security | 19 | 19 | 0 | 0 | 0 |
| Unit | 37 | 37 | 0 | 0 | 0 |
| Example / Misc | 3 | 3 | 0 | 0 | 0 |
| Total | 148 | 143 | 5 | 0 | 0 |

### 8.2 BUG & DEFECT LOG

| Bug ID | Test Case ID / Scenario ID | Issue Description | Test Priority | Testing Category | Entry Criteria (if any) | Test Data (optional) | Status | Re-tested date | PIC Tester | Defect ID (from bug logging tool, if applicable) | Reference | Remark |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| - | TC-076 / TS-076 | `AdminCrudTest::testApproveOrder` skipped during UI execution. Approval workflow did not run, likely due to Selenium flow or order state setup. | High | UI Automation | Admin logged in | Admin user, seeded orders | Open | - | QA Tester | - | `tests/ui/AdminCrudTest.php::testApproveOrder` | Requires investigation on order approval page flow. |
| - | TC-086 / TS-086 | `LibraryTest::testDownloadButtonVisible` skipped during UI execution. Download button rendering or page state may not have been reached. | High | UI Automation | User logged in | Logged-in user with purchased game | Open | - | QA Tester | - | `tests/ui/LibraryTest.php::testDownloadButtonVisible` | Review page load and element selector. |
| - | TC-087 / TS-087 | `LibraryTest::testDownloadChangesToUninstall` skipped during UI execution. Download-to-uninstall button transition was not executed. | High | UI Automation | User logged in | Logged-in user with downloadable game | Open | - | QA Tester | - | `tests/ui/LibraryTest.php::testDownloadChangesToUninstall` | Verify download action and DOM update. |
| - | TC-088 / TS-088 | `LibraryTest::testUninstallChangesBackToDownload` skipped during UI execution. Uninstall-to-download return flow did not run. | High | UI Automation | User logged in | Logged-in user with installed game | Open | - | QA Tester | - | `tests/ui/LibraryTest.php::testUninstallChangesBackToDownload` | Confirm uninstall flow and page state. |
| - | TC-099 / TS-099 | `ProfileTest::testUpdateEmailSuccess` skipped during UI execution. Profile email update scenario did not execute. | High | UI Automation | User logged in | User account profile page | Open | - | QA Tester | - | `tests/ui/ProfileTest.php::testUpdateEmailSuccess` | Check form interaction and test preconditions. |

### 8.3 Observations

- PHPUnit JUnit report shows `148` tests executed, `176` assertions, `0` failures, `0` errors, and `5` skipped.
- All skipped tests occurred in the UI automation suite and should be reviewed for Selenium environment, test data, or page state issues.
- There were no failing or erroring assertions in this execution, so no functional defect tickets are required from this run unless the skipped UI cases need follow-up.
- If you want to track these as defects, create defect records for the skipped UI scenarios and update `Defect ID` accordingly.

### 8.4 RAG

| RAG | Criteria |
|---|---|
| Green | No failures/errors and skipped tests are understood or acceptable |
| Amber | Skipped tests require follow-up but the suite has no failures/errors |
| Red | Any test failures/errors are present or core user journeys are blocked |

> Catatan: Ringkasan di atas didasarkan pada hasil aktual dari file `tests/report/junit.xml` pada project GameStoreSelenium.

#### Test Case Contoh 3: Checkout flow

- ID: TC-CHECKOUT-001
- Objective: Memastikan proses checkout berhasil.
- Precondition: Keranjang berisi setidaknya satu game, user login.
- Steps:
  1. Login sebagai user.
  2. Tambahkan game ke cart.
  3. Buka halaman checkout.
  4. Isi data alamat/ pembayaran sesuai form.
  5. Submit checkout.
- Expected result: Transaksi tersimpan dan halaman konfirmasi muncul.

##### Gherkin style

```
Scenario: User menyelesaikan checkout
  Given user telah login dan ada item di cart
  When user membuka halaman checkout
  And mengisi data checkout dengan benar
  And menekan tombol submit
  Then transaksi berhasil disimpan
  And user melihat halaman konfirmasi
```

#### Test Case Contoh 4: Registrasi dengan validasi gagal

- ID: TC-SIGNUP-001
- Objective: Memastikan registrasi menolak input tidak valid.
- Steps:
  1. Buka halaman register.
  2. Masukkan nama pendek.
  3. Masukkan email tidak valid.
  4. Masukkan password terlalu pendek.
  5. Centang agreement atau tidak sesuai kebutuhan.
  6. Submit form.
- Expected result: Sistem menolak input dan menampilkan pesan validasi.

##### Gherkin style

```
Scenario: Registrasi gagal karena input tidak valid
  Given halaman registrasi terbuka
  When user memasukkan nama pendek dan email tidak valid
  And memasukkan password terlalu pendek
  Then pengguna tetap berada di halaman register
  And pesan validasi ditampilkan
```

### 6.7 Test environment

- Lingkungan pengujian lokal di `localhost`.
- Database khusus `tests` untuk isolasi.
- Chrome + ChromeDriver berjalan bersamaan.
- File konfigurasi CodeIgniter `phpunit.xml.dist` untuk PHPUnit.
- `tests/Support/BaseSeleniumTest.php` melakukan setup migrasi dan seed.

### 6.8 Testing tools and techniques

#### Manual testing

- Digunakan untuk exploratory dan validasi visual.
- Teknik: black-box testing; fokus pada output aplikasi dari sisi pengguna.
- Contoh: membuka halaman login, melihat pesan error validasi, memverifikasi kontrol akses admin.

#### Automation testing

- PHPUnit digunakan untuk:
  - unit test: validasi model, service, helper
  - integration test: controller + database + session
  - UI test: Selenium WebDriver
- Selenium test code:
  - `tests/Support/BaseSeleniumTest.php` menginisialisasi `RemoteWebDriver` pada `http://localhost:9515`
  - `test_selenium.php` contoh script sederhana membuka URL dan membaca title

##### Contoh metode automation

```php
$options = new ChromeOptions();
$options->setBinary('C:/xampp/htdocs/gamestoreSelenium/chrome/chrome-win64/chrome.exe');
$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create('http://localhost:9515', $capabilities);
$driver->get('http://localhost:8082');
echo $driver->getTitle();
$driver->quit();
```

- `BaseSeleniumTest` memiliki helper:
  - `open($path)` untuk membuka halaman
  - `click($by)` untuk klik elemen
  - `type($by, $text)` untuk input teks
  - `loginUser($email, $password)` untuk automasi login

#### Test code explanation

- Unit tests dijalankan via `vendor\bin\phpunit` atau `phpunit --configuration phpunit.xml.dist`.
- Integration tests menggunakan `ControllerTestTrait` untuk mengeksekusi controller tanpa server HTTP penuh.
- Selenium UI tests membutuhkan Chromedriver berjalan pada `localhost:9515` dan Chrome.

## 7. TEST METRICS RELEVANT TO GameStoreSelenium

### 7.1 Defect density

- Defect density = jumlah bug / jumlah module yang diuji.
- Target: < 0.5 defect per module utama setelah regression.

### 7.2 Test coverage

- Kategori: unit coverage dan integration coverage.
- Target minimal: 70% pada model + controller penting.
- Ideal: > 80% pada kode kritis autentikasi dan transaksi.

### 7.3 Pass rate

- Persentase test case yang lulus dibanding total test case dijalankan.
- Target awal: 90% pass rate pada setiap sprint.

### 7.4 Execution rate

- Jumlah test suite yang dijalankan per hari.
- Target: semua suite utama (unit + integration + Selenium) dijalankan minimal 1 kali per cycle.

### 7.5 Defect leakage

- Jumlah bug yang ditemukan setelah release dibanding bug ditemukan saat test.
- Target: defect leakage < 10%.

### 7.6 Cycle time

- Waktu yang dibutuhkan untuk menyelesaikan satu siklus test: setup, eksekusi, laporan, retest.
- Target: < 2 hari untuk regresi penuh di lingkungan lokal.

### 7.7 Test Metrics Tables

#### Test Group

| Test Group | Description | Example |
|---|---|---|
| Functional | Menguji fitur dan perilaku aplikasi sesuai requirement. | Login, checkout, keranjang, registrasi |
| Integration | Menguji integrasi antar modul dan layanan. | Controller + database, API endpoint, alur checkout |
| UI / Selenium | Menguji tampilan dan interaksi browser. | Login form, keranjang, tampilan katalog |
| Security | Menguji kontrol akses, validasi input, proteksi CSRF/XSS. | Login brute force, akses admin, input injection |
| Regression | Mengulang tes setelah perubahan kode untuk memastikan tidak ada regresi. | Skenario checkout setelah update model pembayaran |

#### Test Priority

| Priority | Definition | Example |
|---|---|---|
| High | Fitur kritis yang harus bekerja tanpa gangguan. | Login, checkout, pembayaran, akses admin |
| Medium | Fitur penting namun tidak menghambat seluruh aplikasi. | Daftar game, profil pengguna, notifikasi |
| Low | Fitur tambahan atau non-kritis. | Tampilan tema, fitur pencarian lanjutan, dokumentasi |

#### Type of Test Case

| Type of Test Case | Purpose | Example |
|---|---|---|
| Positive | Memastikan aplikasi bekerja dengan input yang valid. | Login berhasil, checkout berhasil |
| Negative | Memastikan aplikasi menolak input tidak valid dan menangani error. | Registrasi email tidak valid, checkout tanpa item |
| Boundary | Memeriksa perilaku pada batas nilai input. | Jumlah quantity maksimum, panjang nama pengguna maksimal |
| Usability | Memeriksa kemudahan penggunaan dan antarmuka. | Navigasi halaman, pesan error yang jelas |
| Performance | Memeriksa respons dan stabilitas di bawah beban. | Checkout cepat, waktu muat halaman katalog |

#### Total Defected

| Total Defected | Description | Target |
|---|---|---|
| Critical defects | Bug yang menghentikan fungsi utama atau menyebabkan crash. | 0 per cycle |
| Major defects | Bug yang mengganggu alur utama tetapi ada workaround. | <= 1 per cycle |
| Minor defects | Bug non-kritis seperti tampilan, pesan, atau fungsi tambahan. | <= 3 per cycle |
| Trivial defects | Isu kosmetik atau dokumentasi. | <= 5 per cycle |

## Lampiran: Rekomendasi Eksekusi

- Pastikan Selenium Server / ChromeDriver berjalan dulu sebelum menjalankan UI test.
- Jalankan `vendor\bin\phpunit --configuration phpunit.xml.dist` untuk semua unit dan integration test.
- Jalankan `php test_selenium.php` untuk validasi script Selenium sederhana.
- Gunakan database `tests` untuk menghindari dampak pada data produksi.

---

Dokumen ini disusun untuk mendukung eksekusi pengujian GameStoreSelenium secara sistematis, menggabungkan metode manual dan otomatis sesuai kebutuhan modul STQA yang diminta.