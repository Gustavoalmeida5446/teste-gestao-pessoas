const form = document.getElementById("form");
const resultContainer = document.getElementById("result");

function render(entries) {
  resultContainer.innerHTML = "";

  entries.forEach((entry) => {
    const itemDiv = document.createElement("div");
    itemDiv.className = "item";

    itemDiv.innerHTML = `
      <p><strong>ID:</strong> ${entry.id}</p>
      <p><strong>Nome:</strong> ${entry.nome}</p>
      <p><strong>CPF:</strong> ${entry.cpf}</p>
      <p><strong>Idade:</strong> ${entry.idade}</p>
      <p><strong>Data de criação:</strong> ${entry.data_criacao}</p>

      <button class="edit-button">Editar</button>
      <button class="delete-button">Excluir</button>
    `;

    const editButton = itemDiv.querySelector(".edit-button");
    const deleteButton = itemDiv.querySelector(".delete-button");

    editButton.onclick = () => {
      document.getElementById("id").value = entry.id;
      document.getElementById("nome").value = entry.nome;
      document.getElementById("cpf").value = entry.cpf;
      document.getElementById("idade").value = entry.idade;

      document.getElementById("buttonSave").textContent = "Atualizar";
    };

    deleteButton.onclick = async () => {
      const confirmDelete = confirm("Excluir registro?");
      if (!confirmDelete) return;

      await fetch("delete_entry.php?id=" + entry.id);
      loadEntries();
    };

    resultContainer.appendChild(itemDiv);
  });
}

async function loadEntries() {
  const response = await fetch("get_entries.php");
  const entries = await response.json();
  render(entries);
}

form.onsubmit = async (event) => {
  event.preventDefault();

  const formData = new FormData(form);
  const entryId = document.getElementById("id").value;

  const endpoint = entryId ? "update_entry.php" : "create_entry.php";

  await fetch(endpoint, {
    method: "POST",
    body: formData,
  });

  form.reset();
  document.getElementById("buttonSave").textContent = "Cadastrar";

  loadEntries();
};

document.addEventListener("DOMContentLoaded", loadEntries);
