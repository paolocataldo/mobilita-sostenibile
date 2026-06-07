let index = 1;
let container;

document.addEventListener("DOMContentLoaded", function () {

    container = document.getElementById("tratteContainer");

    document.getElementById("addTratta").addEventListener("click", function () {

        const div = document.createElement("div");
        div.classList.add("tratta");

        div.innerHTML = `
    <div class="field">
        <label>Mezzo</label>
        <select name="tratte[${index}][mezzo]" required>
            ${mezziOptions.map(m => `<option value="${m.id}">${m.nome}</option>`).join("")}
        </select>
    </div>
    <div class="row-2">
        <div class="field">
            <label>Km</label>
            <input type="number" name="tratte[${index}][km]" step="0.1" min="0.1" required>
        </div>
        <div class="field">
            <label>Passeggeri</label>
            <input type="number" name="tratte[${index}][passeggeri]" min="1" value="1">
        </div>
    </div>
    <button type="button" class="remove_tratta" onclick="rimuoviTratta(this)">✕ Rimuovi</button>
`;

        container.appendChild(div);
        index++;
    });

});

function rimuoviTratta(btn) {
    btn.closest(".tratta").remove();
    reindex();
}

function reindex() {
    container.querySelectorAll(".tratta").forEach((tratta, i) => {
        tratta.querySelectorAll("input, select").forEach(el => {
            el.name = el.name.replace(/tratte\[\d+\]/, `tratte[${i}]`);
        });
    });
    index = container.querySelectorAll(".tratta").length;
}