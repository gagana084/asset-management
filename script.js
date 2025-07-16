const register = () => {
  const name = document.getElementById("fullName").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  const f = new FormData();
  f.append("name", name);
  f.append("email", email);
  f.append("pw", password);
  f.append("cpw", confirmPassword);

  const r = new XMLHttpRequest();
  r.onreadystatechange = () => {
    if (r.readyState === 4 && r.status === 200) {
      const response = r.responseText;
      if (response === "success") {
        alert("Successful registered");
        window.location = "login.php";
      } else {
        document.getElementById("alert").innerHTML = response;
      }
    }
  };
  r.open("POST", "registerProcess.php", true);
  r.send(f);
};

const login = () => {
  const email = document.getElementById("email").value;
  const pw = document.getElementById("password").value;

  const f = new FormData();
  f.append("email", email);
  f.append("pw", pw);

  const r = new XMLHttpRequest();
  r.onreadystatechange = () => {
    if (r.readyState === 4 && r.status === 200) {
      const response = r.responseText;
      if (response === "success") {
        window.location = "./index.php";
      } else {
        document.getElementById("alert2").innerHTML = response;
      }
    }
  };
  r.open("POST", "loginProcess.php", true);
  r.send(f);
};

const addIncome = () => {
  const amount = document.getElementById("amount").value;
  const type = document.getElementById("type").value;

  const f = new FormData();
  f.append("amount", amount);
  f.append("type", type);

  const r = new XMLHttpRequest();
  r.onreadystatechange = () => {
    if (r.readyState === 4 && r.status === 200) {
      const response = r.responseText;
      alert(response);
      window.location.reload();
    }
  };
  r.open("POST", "incomeAddProcess.php", true);
  r.send(f);
};

const addOutcome = () => {
  const outcome = document.getElementById("amount").value;
  const outComeType = document.getElementById("type").value;

  const f = new FormData();
  f.append("outcome", outcome);
  f.append("type", outComeType);

  const r = new XMLHttpRequest();
  r.onreadystatechange = () => {
    if (r.readyState === 4 && r.status === 200) {
      const response = r.responseText;
      alert(response);
      window.location.reload();
    }
  };
  r.open("POST", "outcomeAddProcess.php", true);
  r.send(f);
};
