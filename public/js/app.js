
document.addEventListener("DOMContentLoaded", () => {
    Livewire.hook('element.initialized', (el, component) => {
        fresh();
        slx_init();
    })
});

window.addEventListener('app.flash.notif', function (event) {
    if (event.detail.type === 'success')
        iziToast.success({
            title: event.detail.title,
            message: event.detail.message,
            timeout: event.detail.timeout,
        });

    if (event.detail.type === 'info')
        iziToast.info({
            title: event.detail.title,
            message: event.detail.message,
            timeout: event.detail.timeout,
        });

    if (event.detail.type === 'error')
        iziToast.error({
            title: event.detail.title,
            message: event.detail.message,
            timeout: event.detail.timeout,
        });

    if (event.detail.type === 'warning')
        iziToast.warning({
            title: event.detail.title,
            message: event.detail.message,
            timeout: event.detail.timeout,
        });
});

fresh();

function switchVsmode() {
    let html = document.getElementsByTagName('html')[0];
    let val = html.classList.value;

    if (val == 'dark') html.classList.replace('dark', 'light');
    else html.classList.replace('light', 'dark');
}

function fresh() {
    feather.replace();

    try {

        window.pond = FilePond.create(document.querySelector('.filepond'));

    } catch (error) {
        console.error('Filepond-Error: tidak ada element yang di temukan');
    }

}

function formatNumber(el) {
    let input = el.value;

    // Menghilangkan karakter selain angka dan koma
    input = input.replace(/[^\d\,]/g, '');

    // Membagi antara bagian desimal dan ribuan
    let parts = input.split(',');
    let ribuan = parts[0];
    let desimal = parts[1] ? ',' + parts[1] : '';

    // Memformat bagian ribuan dengan pemisah ribuan
    ribuan = ribuan.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Menggabungkan bagian ribuan dan desimal
    el.value = "Rp " + ribuan + desimal;
}



function slx_search(context, element, items) {
    let target = element.value;
    let selected_items = [];
    let closest_match = [];

    try {
        selected_items = JSON.parse(context.dataset.selected);
    } catch (error) {
        console.error("[SLX] " + error);
    }

    for (let i = 0; i < items.length; i++) {

        let value = items[i];

        let similarity = stringSimilarity(value, target);

        if (similarity >= 75) closest_match.push(value);

    }

    if (target === "") closest_match = items;

    closest_match = [...new Set(closest_match)];

    let sbox = context.getElementsByClassName('selectable-box')[0];

    sbox.classList.add('show');

    sbox.innerHTML = "";

    for (let i = 0; i < closest_match.length; i++) {
        create_item(closest_match[i], context, selected_items);
    }

    if (closest_match === [] || closest_match.length === 0) {
        let info_el = document.createElement('div');

        info_el.innerHTML = "Keyword tidak di <b>temukan!!</b>";

        info_el.classList.add('slx-info');

        sbox.appendChild(info_el);

    }

}

function slx_init() {
    let el = document.getElementsByClassName('slx-field');

    let fields = Array.from(el);

    let selected_index = [];

    for (let index in fields) {
        let field = fields[index];

        let box = field.getElementsByClassName('selectable-box')[0];

        if (field instanceof Element) {
            let selected_items = [];

            let search_el = field.getElementsByClassName('slx-input')[0];
            let items = JSON.parse(field.dataset.item);

            search_el.oninput = () => slx_search(field, search_el, items);
            search_el.onfocus = () => box.classList.add('show');

            refreshInputeSearch(field);

            try {
                selected_items = JSON.parse(field.dataset.selected);
            } catch (error) {
                console.error("[SLX] " + error);
            }

            for (let i = 0; i < items.length; i++) {

                let item = items[i];

                create_item(item, field, selected_items);

                if (selected_items.includes(item)) {
                    selected_index.push(item);
                }

            }
        }

        let inp = field.querySelector('input[type=hidden]');

        inp.value = JSON.stringify(selected_index);

    }

}

function create_item(item, context, selected_items) {
    let option_el = document.createElement('div');
    let select = context.getElementsByClassName('selectable-box')[0];

    option_el.classList.add('item');
    option_el.value = item;
    option_el.innerHTML = `<span>${item}</span>`;

    option_el.onclick = () => slx_on_item_select(option_el, context, selected_items);
    select.appendChild(option_el);

    let sel = document.createElement('span');
    sel.innerText = "Selected";
    sel.classList.add('slx-visible');
    sel.classList.add('slx-hidden');

    option_el.appendChild(sel);

    if (selected_items.includes(item)) {
        option_el.classList.add('selected');
        sel.classList.remove('slx-hidden');
    }
}

function slx_on_item_select(option_el, context) {

    let inp = context.querySelector('input[type=hidden]');

    old_value = inp.value.length < 1
        ? [] : JSON.parse(inp.value);

    if (option_el.classList.contains('selected') == false) {
        old_value.push(option_el.value);
    } else {
        old_value = old_value.filter(value => value !== option_el.value)
    }

    inp.value = JSON.stringify(old_value);
    context.setAttribute('data-selected', inp.value);

    context.querySelector('.slx-input').placeholder = old_value.length + " | Item Yang Terpilih";

    option_el.classList.toggle('selected');
    option_el.getElementsByClassName('slx-visible')[0].classList.toggle('slx-hidden');

    // push to livewire
    let component = context.dataset.comp;
    let model = context.dataset.model;

    eval(component).set(model, old_value, true);

}

function refreshInputeSearch(context) {
    let value = [];

    try {
        value = JSON.parse(context.dataset.selected);
    } catch (error) {
        console.log('[SLXparseE] ' + error);
    }

    context.querySelector('.slx-input').placeholder = value.length + " | Item Yang Terpilih";
}

function stringSimilarity(s1, s2) {
    const m = s1.length;
    const n = s2.length;

    if (m === 0 || n === 0) {
        return 0;
    }

    const maxDistance = Math.floor(Math.max(m, n) / 2) - 1;

    let matches = 0;
    let transpositions = 0;

    const s1Matches = new Array(m);
    const s2Matches = new Array(n);

    for (let i = 0; i < m; i++) {
        const start = Math.max(0, i - maxDistance);
        const end = Math.min(i + maxDistance + 1, n);

        for (let j = start; j < end; j++) {
            if (s2Matches[j]) {
                continue;
            }

            if (s1[i] !== s2[j]) {
                continue;
            }

            s1Matches[i] = true;
            s2Matches[j] = true;
            matches++;
            break;
        }
    }

    if (matches === 0) {
        return 0;
    }

    let k = 0;

    for (let i = 0; i < m; i++) {
        if (!s1Matches[i]) {
            continue;
        }

        while (!s2Matches[k]) {
            k++;
        }

        if (s1[i] !== s2[k]) {
            transpositions++;
        }

        k++;
    }

    const similarity = (matches / m + matches / n + (matches - transpositions / 2) / matches) / 3;

    return similarity * 100;
}


document.onclick = (e) => {
    let sfields = document.getElementsByClassName('slx-field');


    for (let i = 0; i < sfields.length; i++) {

        let field = sfields[i];

        let box = field.getElementsByClassName('selectable-box')[0];

        if (event.target !== field && !field.contains(event.target)) {
            box.classList.remove('show');
        }
    }

};

