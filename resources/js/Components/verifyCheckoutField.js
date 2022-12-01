const form = document.querySelector('form[id="gui-form"]');

if (document.body.contains(form)) {
    window.addEventListener('load', newsubmit);

    const observer = new MutationObserver(newsubmit);

    form.addEventListener('click', function (event) {
        const attribute = event.target.getAttribute('id');
        if (attribute === 'submitter') {
            const data = new FormData(form);
            let payload = '[payload]';
            for (const value of data.entries()) {
                //which payment are we using?
                if (value[0] === 'payment_method') {
                    payload = value[1].split('|')[1] + payload;
                }
                //Does the payload exist?
                if (value[0] === payload) {
                    //If it exist but it's empty stay on the page.
                    if (value[1] === '') {
                        let scrollToElement = form.querySelector('#gui-form-payment-method');
                        scrollToElement.scrollIntoView();

                        let paymentForm = form.querySelector('.gui-is-selected .gui-payment-method-form');
                        paymentForm.style = 'border:1px solid red; padding: 0 10px;';

                        return false;
                    }
                }
            }
            //if everything is fulled then proceed
            observer.disconnect();
            form.submit();
        }
    });
    //Detect if the submit button has been changed by LS and change it back.
    const submitter = form.querySelector('#gui-block-review');
    if (document.body.contains(submitter)) {
        const config = {attributes: true, childList: true, subtree: true};
        observer.observe(submitter, config);
    }
}

function newsubmit() {
    //Change the submit button into something we can control;
    const onclickAttribute = '$(\'#gui-form\').submit();';
    let submitter = form.querySelectorAll('a[onclick="$(\'#gui-form\').submit();"]');
    if (submitter.length > 1) {
        submitter = form.querySelector('#gui-block-review a[onclick="$(\'#gui-form\').submit();"]');
    } else {
        submitter = submitter[0];
    }
    const newsubmitter = form.querySelectorAll('#submitter');
    if (newsubmitter.length <= 0) {
        if (submitter.getAttribute('onclick') === onclickAttribute) {
            submitter.setAttribute('id', 'submitter');
            submitter.removeAttribute('onclick');
        }
    }
}
