// modal.js
function openModal(src, width=800, height=600) {
  let overlay = document.querySelector(".modal-overlay");
  let modal   = document.querySelector(".modal-window");

  if (!overlay) {
    overlay = document.createElement("div");
    overlay.className = "modal-overlay";
    document.body.appendChild(overlay);

    modal = document.createElement("div");
    modal.className = "modal-window";
    modal.setAttribute("role", "dialog");
    modal.setAttribute("aria-modal", "true");
    document.body.appendChild(modal);
  }

  let content;
  if (/\.(jpg|jpeg|png|gif)$/i.test(src)) {
    content = `<img src="${src}" style="max-width:100%;max-height:100%">`;
  } else {
    content = `<iframe src="${src}" width="${width}" height="${height}" frameborder="0"></iframe>`;
  }

  modal.innerHTML = content + '<span class="close-window">&times;</span>';
  modal.style.width = width + "px";
  modal.style.height = height + "px";

  overlay.style.display = "block";
  modal.style.display = "block";

  modal.querySelector(".close-window").onclick = closeModal;
  overlay.onclick = closeModal;
  document.onkeyup = (e) => { if (e.key === "Escape") closeModal(); };
}

function closeModal(){
  document.querySelector(".modal-overlay").style.display = "none";
  document.querySelector(".modal-window").style.display = "none";
}
