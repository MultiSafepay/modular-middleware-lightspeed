import PaymentComponent from "./PaymentComponent";

export default class MultiSafepayCheckout {
    async LoadPaymentComponents(paymentMethods, amountInCents) {
        await this.addScript();
        await this.addStyle();

        for (const paymentMethod of paymentMethods) {
            if (paymentMethod.data.hasComponent ?? false) {
                let component = new PaymentComponent(paymentMethod.id, amountInCents, paymentMethod.data.currency.toUpperCase(), paymentMethod.data.token, 'test');
                component.load();
            }
        }
    };

    async addScript() {
        await new Promise((resolve, reject) => {
            if (document.getElementById('componentjs')) {
                resolve(true);
                return;
            }
            const script = document.createElement('script');
            script.async = true;
            script.defer = false;
            script.src = 'https://pay.multisafepay.com/sdk/components/v2/components.js';
            script.id = 'componentjs'

            document.head.appendChild(script);
            script.addEventListener('load', () => {
                resolve(true);
            });
        });
    }

    async addStyle() {
        await new Promise((resolve, reject) => {
            if (document.getElementById('componentcss')) {
                resolve(true);
                return;
            }
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = 'https://pay.multisafepay.com/sdk/components/v2/components.css';
            link.id = 'componentcss';
            document.head.appendChild(link);
            resolve(true);
        });
    }
}
