try {
    let cartForm = document.getElementById('cart_form');
    if (cartForm) cartForm.addEventListener('click', setHandledItemId);
} catch (e) {
    console.log(e.message);
}

function setHandledItemId(event) {
    if (event.target.tagName !== 'BUTTON') return;

    let itemRow = event.target.parentNode.parentNode;
    let itemQty = itemRow.querySelector('input[type=number]');
    document.getElementById('handle_by_id').value = itemQty.name;
    document.getElementById('cart_form').submit();
    return true;
}