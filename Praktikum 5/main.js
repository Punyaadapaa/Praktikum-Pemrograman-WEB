const API_URL = "https://jsonplaceholder.typicode.com/users";

function hideNotif(elId) {
  $("#" + elId).removeClass("success error loading show").text("");
}

// pindah halaman
$("#goToRegister").on("click", function (e) {
  e.preventDefault();
  $("#loginBox").addClass("hidden");
  $("#registerBox").removeClass("hidden");
  hideNotif("registerNotif");
});

$("#goToLogin").on("click", function (e) {
  e.preventDefault();
  $("#registerBox").addClass("hidden");
  $("#loginBox").removeClass("hidden");
  hideNotif("loginNotif");
});

// login
$("#loginBtn").on("click", function () {
  var email = $("#loginEmail").val().trim();
  var password = $("#loginPassword").val().trim();
  var $notif = $("#loginNotif");

  if (!email || !password) {
    $notif.removeClass("success error loading show").addClass("error show").text("Email dan password wajib diisi.");
    return;
  }

  $("#loginBtn").prop("disabled", true);
  $("#loginBtnLabel").text("Loading...");
  $notif.removeClass("success error loading show").addClass("loading show").text("Mengautentikasi...");

  $.ajax({
    url: API_URL,
    method: "GET",
    dataType: "json",
    success: function (data) {
      var found = null;
      $.each(data, function (i, user) {
        if (user.email.toLowerCase() === email.toLowerCase()) {
          found = user;
          return false;
        }
      });

      if (found) {
        $notif.removeClass("success error loading show").addClass("success show").text("Login berhasil! Selamat datang, " + found.name);
      } else {
        $notif.removeClass("success error loading show").addClass("error show").text("Email tidak ditemukan. Coba: Sincere@april.biz");
      }

      $("#loginBtn").prop("disabled", false);
      $("#loginBtnLabel").text("Login");
    },
    error: function () {
      $notif.removeClass("success error loading show").addClass("error show").text("Gagal terhubung ke server. Coba lagi.");
      $("#loginBtn").prop("disabled", false);
      $("#loginBtnLabel").text("Login");
    },
  });
});

// register
$("#registerBtn").on("click", function () {
  var name     = $("#regName").val().trim();
  var username = $("#regUsername").val().trim();
  var email    = $("#regEmail").val().trim();
  var password = $("#regPassword").val().trim();
  var $notif   = $("#registerNotif");

  if (!name || !username || !email || !password) {
    $notif.removeClass("success error loading show").addClass("error show").text("Semua field wajib diisi.");
    return;
  }

  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    $notif.removeClass("success error loading show").addClass("error show").text("Format email tidak valid.");
    return;
  }

  if (password.length < 6) {
    $notif.removeClass("success error loading show").addClass("error show").text("Password minimal 6 karakter.");
    return;
  }

  $("#registerBtn").prop("disabled", true);
  $("#registerBtnLabel").text("Loading...");
  $notif.removeClass("success error loading show").addClass("loading show").text("Mendaftarkan akun...");

  var newUser = {
    name: name,
    username: username,
    email: email,
  };

  $.ajax({
    url: API_URL,
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(newUser),
    success: function (response) {
      $notif.removeClass("success error loading show").addClass("success show").text("Akun berhasil dibuat! ID: " + response.id + ". Silakan login.");

      $("#regName, #regUsername, #regEmail, #regPassword").val("");

      setTimeout(function () {
        $("#registerBox").addClass("hidden");
        $("#loginBox").removeClass("hidden");
        hideNotif("loginNotif");
        $("#loginNotif").removeClass("success error loading show").addClass("success show").text("Registrasi berhasil! Silakan login.");
      }, 2000);

      $("#registerBtn").prop("disabled", false);
      $("#registerBtnLabel").text("Register");
    },
    error: function () {
      $notif.removeClass("success error loading show").addClass("error show").text("Gagal mendaftarkan akun. Coba lagi.");
      $("#registerBtn").prop("disabled", false);
      $("#registerBtnLabel").text("Register");
    },
  });
});
