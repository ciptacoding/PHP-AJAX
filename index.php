<?php require 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include APP_ROOT . '/includes/head.php'; ?>
  <title><?= SITE_NAME ?> - Mahasiswa</title>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include APP_ROOT . '/includes/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include APP_ROOT . '/includes/navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row mb-4">

            <div class="col-md-7">

              <div class="card shadow">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
                </div>
                <div class="card-body">

                  <div class="row justify-content-between align-items-center mb-1">
                    <div class="col-auto">
                      <div class="form-group form-row align-items-center mb-0">
                        <label for="perPage" class="col-sm-auto col-form-label">Show</label>
                        <div class="col-sm-auto">
                          <select class="form-control form-control-sm" id="perPage" name="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <div class="form-group form-row align-items-center mb-0">
                        <label for="keyword" class="col-sm-auto col-form-label">Search</label>
                        <div class="col-sm-auto">
                          <input type="text" class="form-control form-control-sm" id="keyword">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="mhs-wrapper"></div>

                </div>
              </div>
            </div>

            <div class="col-md-5">
              <div class="card shadow" id="mhs-tambah">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Mahasiswa</h6>
                </div>
                <div class="card-body">
                  <form>
                    <input type="hidden" id="id">
                    <input type="hidden" id="fotoLama">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" id="nama">
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <label for="nim">Nim</label>
                      <input type="text" class="form-control" id="nim">
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" id="email">
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <label for="jurusan">Jurusan</label>
                      <select class="form-control" id="jurusan">
                        <option value=""></option>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <label for="foto">Foto</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto">
                        <label class="custom-file-label" for="foto">Choose file</label>
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                      <button type="button" class="btn btn-secondary mr-1">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include APP_ROOT . '/includes/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <?php include APP_ROOT . '/includes/scroll-to-top.php'; ?>

  <!-- Modal -->
  <div class="modal fade" id="detailMhsModal" tabindex="-1" aria-labelledby="detailMhsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailMhsModalLabel">Detail Mahasiswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Script -->
  <?php include APP_ROOT . '/includes/script.php'; ?>

  <script>
    const mhsWrapper = document.querySelector('#mhs-wrapper');
    const perPage = document.querySelector('#perPage');
    const keyword = document.querySelector('#keyword');

    const mhsTambah = document.getElementById('mhs-tambah');
    const form = mhsTambah.querySelector('form');
    const btnSave = form.querySelector('button[type=submit]');
    const btnCancel = form.querySelector('button[type=button]');

    btnCancel.classList.add('d-none');

    const fields = ['nama', 'nim', 'email', 'jurusan', 'foto'];
    let isNamaValid = isEmailValid = isNimValid = isJurusanValid = false;
    let isFotoValid = true;

    function ajaxPost(url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          callback(this);
        }
      }
      xhr.open('POST', url, true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(data);
    }

    function ajaxGet(url, callback) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          callback(this);
        }
      }
      xhr.open('GET', url, true);
      xhr.send();
    }

    function resetInput() {
      form.nama.value = '';
      form['nim'].value = '';
      form.email.value = '';
      form['jurusan'].value = '';
      document.getElementById('fotoLama').value = '';
      document.getElementById('id').value = '';
      document.querySelector('input[type="file"]').value = '';
      document.querySelector('.custom-file-label').textContent = 'Choose file';

      btnCancel.classList.add('d-none');
      btnSave.innerHTML = 'Simpan';
      mhsTambah.querySelector('h6').innerHTML = 'Tambah Mahasiswa';

      fields.forEach(function(field) {
        const input = document.getElementById(field);
        input.classList.remove('is-invalid');
      });

      const msgInvalid = document.querySelectorAll('.invalid-feedback');
      msgInvalid.forEach(function(message) {
        message.innerText = '';
      });
    }

    function setStatus(field, status, message = '') {
      status === 'error' ? field.classList.add('is-invalid') : field.classList.remove('is-invalid');
      field.nextElementSibling.innerText = message;
    }

    function validateFields(field) {

      if (field.id == 'nama') {
        if (!field.value.trim()) {
          isNamaValid = false;
          setStatus(field, 'error', `${field.previousElementSibling.innerText} tidak boleh kosong!`);
        } else {
          const re = /^[a-zA-Z\s]+$/;
          if (!re.test(field.value)) {
            isNamaValid = false;
            setStatus(field, 'error', `${field.previousElementSibling.innerText} hanya mengandung huruf dan spasi!`);
          } else {
            isNamaValid = true;
            setStatus(field, 'success');
          }
        }
      }

      if (field.id == 'nim') {
        if (!field.value.trim()) {
          isNimValid = false;
          setStatus(field, 'error', `${field.previousElementSibling.innerText} tidak boleh kosong!`);
        } else {
          const re = /^\d+$/;
          if (!re.test(field.value)) {
            isNimValid = false;
            setStatus(field, 'error', `${field.previousElementSibling.innerText} hanya mengandung angka!`);
          } else {
            if (field.value.length < 9) {
              isNimValid = false;
              setStatus(field, 'error', `Panjang ${field.previousElementSibling.innerText} harus 9 digit!`);
            } else {
              const data = 'nim=' + form.nim.value + '&id=' + form.id.value;
              ajaxPost('check-nim.php', data, function(xhr) {
                if (xhr.responseText) {
                  isNimValid = false;
                  field.classList.add('is-invalid');
                  field.nextElementSibling.innerText = `${xhr.responseText}`;
                } else {
                  isNimValid = true;
                  field.classList.remove('is-invalid');
                  field.nextElementSibling.innerText = null;
                }
              });
            }
          }
        }
      }

      if (field.id == 'email') {
        if (!field.value.trim()) {
          isEmailValid = false;
          setStatus(field, 'error', `${field.previousElementSibling.innerText} tidak boleh kosong!`);
        } else {
          const regex = /^\S+@\S+\.\S+$/;
          if (!regex.test(field.value)) {
            isEmailValid = false;
            setStatus(field, 'error', `${field.previousElementSibling.innerText} tidak valid!`);
          } else {
            const data = 'email=' + form.email.value + '&id=' + form.id.value;
            ajaxPost('check-email.php', data, function(xhr) {
              if (xhr.responseText) {
                isEmailValid = false;
                field.classList.add('is-invalid');
                field.nextElementSibling.innerText = `${xhr.responseText}`;
              } else {
                isEmailValid = true;
                field.classList.remove('is-invalid');
                field.nextElementSibling.innerText = null;
              }
            });
          }
        }
      }

      if (field.id == 'jurusan') {
        if (!field.value.trim()) {
          isJurusanValid = false;
          setStatus(field, 'error', `${field.previousElementSibling.innerText} tidak boleh kosong!`);
        } else {
          isJurusanValid = true;
          setStatus(field, 'success');
        }
      }

      if (field.id == 'foto') {
        if (field.files.length) {
          const fileName = field.files[0].name;
          const fileSize = field.files[0].size;
          const extension = fileName.substr(fileName.lastIndexOf('.'));
          const allowedExts = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

          if (allowedExts.test(extension)) {
            isFotoValid = true;
            field.classList.remove('is-invalid');
            field.nextElementSibling.nextElementSibling.innerText = null;
          } else {
            isFotoValid = false;
            field.classList.add('is-invalid');
            field.nextElementSibling.nextElementSibling.innerText = 'Extension file tidak valid!';
          }

          if (isFotoValid) {
            if (Math.round(fileSize / 1024) <= 2 * 1024) {
              isFotoValid = true;
              field.classList.remove('is-invalid');
              field.nextElementSibling.nextElementSibling.innerText = null;
            } else {
              isFotoValid = false;
              field.classList.add('is-invalid');
              field.nextElementSibling.nextElementSibling.innerText = 'Ukuran file tidak boleh lebih dari 2MB!';
            }
          }
        }
      }

    }

    fields.forEach(function(field) {
      const input = document.getElementById(field);
      input.addEventListener('input', function(e) {
        validateFields(input);
      });
    });

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // fields.forEach(function(field) {
      //   const input = document.getElementById(field);
      //   validateFields(input);
      // });

      for (const field of fields) {
        const input = document.getElementById(field);
        validateFields(input);
      }

      for (const field of fields) {
        const input = document.getElementById(field);
        if (input.classList.contains('is-invalid')) {
          input.focus();
          break;
        }
      }

      let isFormValid = isNamaValid && isNimValid && isEmailValid && isJurusanValid && isFotoValid;

      if (isFormValid) {
        const data = new FormData();
        data.append('nama', form.nama.value);
        data.append('nim', form['nim'].value);
        data.append('email', e.target.email.value);
        data.append('jurusan', e.target['jurusan'].value);
        data.append('foto', document.getElementById('foto').files[0]);
        data.append('fotoLama', form.fotoLama.value);
        data.append('id', form.id.value);

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            resetInput();
            alert(this.responseText);
            btnSave.innerHTML = 'Simpan';
            btnCancel.classList.add('d-none');
            mhsTambah.querySelector('h6').innerHTML = 'Tambah Mahasiswa';
            loadData(perPage.value);
          }
        }
        xhr.open('POST', 'save.php', true);
        xhr.send(data);
      }
    });

    function loadData(perPage, keyword = '', page = 1) {
      ajaxGet('fetch.php?perPage=' + perPage + '&keyword=' + keyword + '&page=' + page, function(xhr) {
        mhsWrapper.innerHTML = xhr.responseText;
      });
    }

    loadData(perPage.value);

    perPage.addEventListener('change', function(e) {
      loadData(this.value, keyword.value.trim(), 1);
    });

    keyword.addEventListener('keyup', function(e) {
      loadData(perPage.value, this.value.trim(), 1);
    });

    mhsWrapper.addEventListener('click', function(e) {
      e.preventDefault();

      if (e.target.hasAttribute('data-page')) {
        loadData(perPage.value, keyword.value.trim(), e.target.dataset.page);
      }

      if (e.target.classList.contains('detail-mhs')) {
        ajaxGet('detail.php?id=' + e.target.dataset.id, function(xhr) {
          document.querySelector('.modal-body').innerHTML = xhr.responseText;
        });
      }

      if (e.target.classList.contains('delete-mhs')) {
        if (confirm('yakin?')) {
          ajaxGet('delete.php?id=' + e.target.dataset.id, function(xhr) {
            alert(xhr.responseText);
            resetInput();
            loadData(perPage.value);
          });
        }
      }

      if (e.target.classList.contains('edit-mhs')) {
        resetInput();
        mhsTambah.querySelector('h6').innerHTML = 'Edit Mahasiswa';
        btnCancel.classList.remove('d-none');
        btnSave.innerHTML = 'Update';

        ajaxGet('edit.php?id=' + e.target.dataset.id, function(xhr) {
          const data = JSON.parse(xhr.responseText);
          form.nama.value = data.nama;
          form['nim'].value = data.nim;
          form.email.value = data.email;
          form['jurusan'].value = data.id_jurusan;
          document.getElementById('fotoLama').value = data.foto;
          document.getElementById('id').value = data.id;
        });

      }
    });

    btnCancel.addEventListener('click', function(e) {
      resetInput();
    });

    function loadJurusan() {
      ajaxGet('jurusan.php', function(xhr) {
        const result = JSON.parse(xhr.responseText);
        const jurusan = document.querySelector('#jurusan');
        for (let [index, data] of Object.entries(result)) {
          jurusan.insertAdjacentHTML('beforeend', `<option value="${data.id}">${data.nama}</option>`);
        }
      });
    }

    loadJurusan();
  </script>
</body>

</html>