document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("inscriptionForm");
  const modal = document.getElementById("confirmationModal");
  const fileUploadArea = document.getElementById("fileUploadArea");
  const fileInput = document.getElementById("fileInput");
  const fileList = document.getElementById("fileList");
  const errorDiv = document.getElementById("fileError");

  let uploadedFiles = [];

  /* ---------------- FILE UPLOAD ---------------- */
  fileUploadArea.addEventListener("click", () => fileInput.click());

  fileUploadArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    fileUploadArea.classList.add("drag-over");
  });

  fileUploadArea.addEventListener("dragleave", () => {
    fileUploadArea.classList.remove("drag-over");
  });

  fileUploadArea.addEventListener("drop", (e) => {
    e.preventDefault();
    fileUploadArea.classList.remove("drag-over");
    handleFiles(e.dataTransfer.files);
  });

  fileInput.addEventListener("change", () => handleFiles(fileInput.files));

  function handleFiles(files) {
    for (let file of files) {
      if (file.size > 10485760) {
        showError(`El archivo ${file.name} excede 10MB`);
        continue;
      }

      const validTypes = ["image/jpeg", "image/jpg", "image/png", "application/pdf"];
      if (!validTypes.includes(file.type)) {
        showError(`El archivo ${file.name} no es válido (solo JPG, PNG o PDF)`);
        continue;
      }

      if (uploadedFiles.length >= 2) {
        showError("Máximo 2 archivos permitidos");
        break;
      }

      uploadedFiles.push(file);
      errorDiv.style.display = "none";
    }
    updateFileList();
  }

  function showError(msg) {
    errorDiv.textContent = msg;
    errorDiv.style.display = "block";
  }

  function updateFileList() {
    fileList.innerHTML = "";

    if (uploadedFiles.length === 0) {
      fileList.innerHTML = "<p>No se han subido archivos</p>";
      return;
    }

    uploadedFiles.forEach((file, index) => {
      const fileItem = document.createElement("div");
      fileItem.className = "file-item";
      fileItem.innerHTML = `
        <span><i class="fas fa-file"></i> ${file.name}</span>
        <button type="button" data-index="${index}" class="remove-btn">
          <i class="fas fa-times"></i>
        </button>
      `;
      fileList.appendChild(fileItem);
    });

    fileList.querySelectorAll(".remove-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const index = parseInt(btn.dataset.index);
        uploadedFiles.splice(index, 1);
        updateFileList();
      });
    });
  }

  /* ---------------- VALIDACIONES ---------------- */
  const validators = {
    email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
    fullName: (val) => val.trim().length >= 5,
    dni: (val) => /^\d{7,9}$/.test(val),
    address: (val) => val.trim().length >= 5,
    city: (val) => val.trim().length >= 3,
    phone: (val) => /^\d{8,}$/.test(val.replace(/\D/g, "")),
    birthdate: (val) => /^\d{2}\/\d{2}\/\d{4}$/.test(val) && isValidDate(val),
    career: (val) => val !== "",
    terms: (checked) => checked === true,
  };

  function isValidDate(dateStr) {
    const [d, m, y] = dateStr.split("/").map(Number);
    const date = new Date(y, m - 1, d);
    return date.getFullYear() === y && date.getMonth() === m - 1 && date.getDate() === d;
  }

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    let isValid = true;

    Object.keys(validators).forEach((field) => {
      const input = document.getElementById(field);
      const error = document.getElementById(field + "Error");

      const value = field === "terms" ? input.checked : input.value;
      if (!validators[field](value)) {
        error.style.display = "block";
        isValid = false;
      } else {
        error.style.display = "none";
      }
    });

    if (uploadedFiles.length === 0) {
      showError("Debes subir al menos un archivo");
      isValid = false;
    }

    if (isValid) modal.style.display = "flex";
  });

 
  // Init
  updateFileList();
});
