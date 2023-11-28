//Notification
function toastNotif(setting) {
    let notifs = document.getElementById("toasts");
    let toast = document.createElement("div");
    toast.style.backgroundColor = setting.color;
    toast.classList.add('toast', 'toast-show');
    icon = document.createElement("i");
    icon.classList.add('icon-' + setting.icon);

    let text = document.createElement("p");
    text.appendChild(document.createTextNode(setting.text));

    toast.appendChild(icon);
    toast.appendChild(text);
    notifs.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('toast-show')
        toast.classList.add('toast-hide')
        setTimeout(() => {
            toast.remove()
        }, 300)
    }, setting.timeout);
}
//
function MsgSuccess(txt) {
    toastNotif({
        text: txt,
        color: '#2AA876',
        timeout: 5000,
        icon: 'check'
    });
}
function MsgWarring(txt) {
    toastNotif({
        text: txt,
        color: '#ffc107',
        timeout: 5000,
        icon: 'warning'
    });
}
function MsgError(txt) {
    toastNotif({
        text: txt,
        color: '#dc3545',
        timeout: 5000,
        icon: 'close-outline'
    });
}
//