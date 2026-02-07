class List extends HTMLElement {
    constructor () {
        super();
        this.nombre;
        this.apellido;
    }

    // solo define los atributos
    static get observedAttributes() { 
        return ['nombre', 'apellido']; 
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        switch (nameAtr) {
            case 'nombre':
                this.nombre = newValue;
            brake;
            case 'apellido':
                this.apellido = newValue;
            brake;
        }
    }

    connectedCallback () {
        let shadowRoot = this.attachShadow({mode:'open'});
        shadowRoot.innerHTML = `
            <div>Hola ${this.nombre} ${this.apellido}</div>
        `;
        this.style.color = 'yellow';
    }
}

customElements.define("app-list", List);