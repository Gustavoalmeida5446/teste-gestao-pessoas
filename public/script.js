const form = document.getElementById("form");
const resultContainer = document.getElementById("result");
const API_URL = "/teste-gestao-pessoas/api/pessoas";

let editingId = null;

function render(people) {
  resultContainer.innerHTML = "";

  people.forEach((person) => {
    const div = document.createElement("div");
    div.className = "item";
    div.innerHTML = `
      ID: ${person.id}<br>
      Nome: ${person.nome}<br>
      CPF: ${person.cpf}<br>
      Idade: ${person.idade}<br>
      Data: ${person.data_criacao}<br>
      <button class="edit-button">Editar</button>
      <button class="delete-button">Excluir</button>
    `;

    div.querySelector(".edit-button").onclick = () => {
      editingId = person.id;
      document.getElementById("nome").value = person.nome;
      document.getElementById("cpf").value = person.cpf;
      document.getElementById("idade").value = person.idade;
      document.getElementById("buttonSave").textContent = "Atualizar";
    };

    div.querySelector(".delete-button").onclick = async () => {
      if (!confirm("Excluir?")) return;

      await fetch(`${API_URL}/${person.id}`, { method: "DELETE" });
      loadData();
    };

    resultContainer.appendChild(div);
  });
}

async function loadData() {
  const response = await fetch(API_URL);
  const people = await response.json();
  render(people);
}

form.onsubmit = async (event) => {
  event.preventDefault();

  const name = document.getElementById("nome").value;
  const cpf = document.getElementById("cpf").value;
  const age = document.getElementById("idade").value;

  if (editingId) {
    const data = `name=${name}&cpf=${cpf}&age=${age}`;
    await fetch(`${API_URL}/${editingId}`, {
      method: "PUT",
      body: data,
    });
    editingId = null;
  } else {
    const formData = new FormData(form);
    await fetch(API_URL, { method: "POST", body: formData });
  }

  form.reset();
  document.getElementById("buttonSave").textContent = "Cadastrar";
  loadData();
};

document.addEventListener("DOMContentLoaded", loadData);
