const form = document.getElementById("form");
const result = document.getElementById("result");
const API_PEOPLE = "api/pessoas";
const API_ADDRESSES = "api/enderecos";

let editingId = null;

function showPeople(people) {
  result.innerHTML = "";

  people.forEach((person) => {
    const div = document.createElement("div");
    div.className = "item";
    const formattedDate = person.data_criacao.split("-").reverse().join("/");
    div.innerHTML = `
      <div class="card-content">
          <div class="card-header">
              <span class="card-name">${person.nome}</span>
              <span class="card-id">ID #${person.id}</span>
          </div>

          <div class="card-grid">
              <div class="data-group">
                  <span class="data-label">CPF</span>
                  <span class="data-value">${person.cpf}</span>
              </div>
              
              <div class="data-group">
                  <span class="data-label">Idade</span>
                  <span class="data-value">${person.idade} anos</span>
              </div>

              <div class="data-group">
                  <span class="data-label">Data</span>
                  <span class="data-value">${formattedDate}</span>
              </div>

              <div class="data-group full-width">
                  <span class="data-label">Endereço</span>
                  <span class="data-value address" id="addr-${person.id}">
                    Carregando...
                  </span>
              </div>
          </div>
      </div>

      <div class="card-actions">
          <button class="edit-button" title="Editar">
            <span class="material-symbols-outlined">edit</span>
          </button>
          
          <button class="delete-button" title="Excluir">
            <span class="material-symbols-outlined">delete</span>
          </button>
      </div>
    `;

    showAddress(person.id);

    div.querySelector(".edit-button").onclick = async () => {
      editingId = person.id;
      document.getElementById("nome").value = person.nome;
      document.getElementById("cpf").value = person.cpf;
      document.getElementById("idade").value = person.idade;

      const res = await fetch(`${API_ADDRESSES}?person_id=${person.id}`);
      const addr = await res.json();

      document.getElementById("endereco").value = addr ? addr.endereco : "";
      document.getElementById("buttonSave").textContent = "Atualizar";
    };

    div.querySelector(".delete-button").onclick = async () => {
      if (!confirm("Excluir?")) return;
      await fetch(`${API_PEOPLE}?id=${person.id}`, { method: "DELETE" });
      loadPeople();
    };

    result.appendChild(div);
  });
}

async function showAddress(personId) {
  const res = await fetch(`${API_ADDRESSES}?person_id=${personId}`);
  const addr = await res.json();

  const span = document.getElementById(`addr-${personId}`);

  if (addr) {
    span.innerHTML = `Endereço: ${addr.endereco}`;
  } else {
    span.innerHTML = "Sem endereço";
  }
}

async function loadPeople() {
  const res = await fetch(API_PEOPLE);
  const people = await res.json();
  showPeople(people);
}

form.onsubmit = async (e) => {
  e.preventDefault();

  const name = document.getElementById("nome").value;
  const cpf = document.getElementById("cpf").value;
  const age = document.getElementById("idade").value;
  const addr = document.getElementById("endereco").value;

  if (editingId) {
    const data = `name=${name}&cpf=${cpf}&age=${age}`;
    await fetch(`${API_PEOPLE}?id=${editingId}`, {
      method: "PUT",
      body: data,
    });

    const addrData = `address=${addr}`;
    await fetch(`${API_ADDRESSES}?person_id=${editingId}`, {
      method: "PUT",
      body: addrData,
    });

    editingId = null;
  } else {
    const formData = new FormData(form);
    await fetch(API_PEOPLE, { method: "POST", body: formData });

    const res = await fetch(API_PEOPLE);
    const people = await res.json();
    const newId = people[0].id;

    if (addr.trim() !== "") {
      const addrData = new FormData();
      addrData.append("person_id", newId);
      addrData.append("address", addr);
      await fetch(API_ADDRESSES, { method: "POST", body: addrData });
    }
  }

  form.reset();
  document.getElementById("buttonSave").textContent = "Cadastrar";
  loadPeople();
};

document.addEventListener("DOMContentLoaded", loadPeople);
