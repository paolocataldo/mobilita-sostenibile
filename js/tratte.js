const MEZZI_PUBBLICI = { 15: 'bus', 16: 'treno' };

const OPZIONI_RIEMPIMENTO = {
    bus:   ['vuoto','poco','medio','tanto'],
    treno: ['vuoto','medio','pieno']
};

let index = 1;
let container;

document.addEventListener("DOMContentLoaded", function () {

    container = document.getElementById("tratteContainer");

    // Gestisci la prima tratta già presente nell'HTML
    const primaTratta = container.querySelector(".tratta");
    if (primaTratta) {
        aggiungiListenerMezzo(primaTratta, 0);
    }

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
        <div class="field passeggeri-field">
            <label>Passeggeri</label>
            <input type="number" name="tratte[${index}][passeggeri]" min="1" value="1">
        </div>
        <div class="field riempimento-field" style="display:none">
            <label>Riempimento</label>
            <select name="tratte[${index}][riempimento]"></select>
        </div>
    </div>
    <button type="button" class="remove_tratta" onclick="rimuoviTratta(this)">✕ Rimuovi</button>
`;

        container.appendChild(div);
        aggiungiListenerMezzo(div, index);
        index++;
    });

});

function aggiungiListenerMezzo(tratta, i) {
    const select = tratta.querySelector(`select[name="tratte[${i}][mezzo]"]`);
    if (!select) return;
    select.addEventListener("change", function () {
        aggiornaCampi(tratta, parseInt(this.value));
    });
    // Stato iniziale
    aggiornaCampi(tratta, parseInt(select.value));
}

function aggiornaCampi(tratta, idMezzo) {
    const passeggeriField  = tratta.querySelector(".passeggeri-field");
    const riempimentoField = tratta.querySelector(".riempimento-field");

    if (!passeggeriField || !riempimentoField) return;

    const tipo = MEZZI_PUBBLICI[idMezzo]; // 'bus' | 'treno' | undefined

    if (tipo) {
        passeggeriField.style.display  = "none";
        riempimentoField.style.display = "";

        const sel = riempimentoField.querySelector("select");
        const opzioni = OPZIONI_RIEMPIMENTO[tipo];
        sel.innerHTML = opzioni
            .map(o => `<option value="${o}">${o.charAt(0).toUpperCase() + o.slice(1)}</option>`)
            .join("");
        sel.value = "medio";

    } else {
        passeggeriField.style.display  = "";
        riempimentoField.style.display = "none";
        const passeggeriInput = passeggeriField.querySelector("input");
        if (!passeggeriInput.value) passeggeriInput.value = 1;
    }
}

function rimuoviTratta(btn) {
    btn.closest(".tratta").remove();
    reindex();
}

function reindex() {
    container.querySelectorAll(".tratta").forEach((tratta, i) => {
        tratta.querySelectorAll("input, select").forEach(el => {
            el.name = el.name.replace(/tratte\[\d+\]/, `tratte[${i}]`);
        });
        // Aggiorna il listener con il nuovo indice
        aggiungiListenerMezzo(tratta, i);
    });
    index = container.querySelectorAll(".tratta").length;
}