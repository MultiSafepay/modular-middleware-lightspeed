const APP_NAME = process.env.MIX_APP_NAME.toLowerCase().replaceAll(" ", "-").replace(/-+/g,"-");

export default class PaymentComponent {
    #gateway;
    #amount;
    #currency;
    #token;
    #environment;
    #container;

    constructor(gateway, amount, currency, token, environment) {
        this.#gateway = gateway;
        this.#amount = amount;
        this.#currency = currency;
        this.#token = token;
        this.#environment = environment;
        this.#container = this.createContainer();
    }

    load() {
        let component = window[`${this.#gateway}-component-${APP_NAME}`] ?? null;
        if (component === null) {
            component = new window.MultiSafepay({
                env: this.#environment,
                apiToken: this.#token,
                order: this.getOrder(),
            });
            window[`${this.#gateway}-component-${APP_NAME}`] = component;
        }

        let input = this.getInputfield();

        component.init('payment', {

            container: `#${APP_NAME}-${this.#gateway}-component`,
            gateway: this.#gateway,
            order: this.getOrder(),
            onLoad: state => {
            },
            onError: state => {
                console.log('onError', state);
            },
            onValidation: state => {
                if (state['valid']) {
                    input.value = component.getPaymentData()['payload'];
                }
            },
        });
    }

    getOrder() {
        return {
            currency: this.#currency,
            amount: this.#amount,
            template: {
                settings: {
                    embed_mode: true
                }
            }
        };
    }

    getInputfield() {
        let input = this.#container.querySelector(`input[name="${this.#gateway}[payload]"]`);
        if (!input) {
            input = document.createElement('input');
            input.name = `${this.#gateway}[payload]`;
            input.style.display = 'none';
            this.#container.appendChild(input);
        }

        return input;
    }

    createContainer() {
        let container = document.querySelector(`#${APP_NAME}-${this.#gateway}-component`);
        if (!container) {
            container = document.createElement('div');
            container.className = 'gui-payment-method-form';
            container.id = `${APP_NAME}-${this.#gateway}-component`;
            document.querySelector(`label[for="gui-payment-${APP_NAME}-${this.#gateway}"]`).appendChild(container);
        }
        return container;
    }
}
