import MultiSafepayCheckout from "./MultiSafepayCheckout";

const APP_NAME = process.env.MIX_APP_NAME.toLowerCase().replaceAll(" ", "-").replace(/-+/g,"-");

const createMultiSafepayCheckout = async () => {
    let mspCheckout = new MultiSafepayCheckout();
    await mspCheckout.LoadPaymentComponents(Object.values(Checkout.data.payment_methods.data[APP_NAME].methods), Math.round(Checkout.data.quote.price_incl * 100));

    if (Checkout.data.theme === "onestep" || Checkout.data.theme === "onepage") {
        let oldUpdate = Checkout.update;
        Checkout.update = async params => {
            await oldUpdate(params);
            await mspCheckout.LoadPaymentComponents(Object.values(Checkout.data.payment_methods.data[APP_NAME].methods), Math.round(Checkout.data.quote.price_incl * 100));
        };
    }
};

if (window.hasOwnProperty("Checkout") && Checkout?.data?.payment_methods) {
    createMultiSafepayCheckout();
}
