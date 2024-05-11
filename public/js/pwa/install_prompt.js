   let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing on mobile
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Show the install button
    showInstallButton();
});

    function showInstallButton() {
    // You can add code here to show an install button in your UI
    // For example:
    const installButton = document.getElementById('installButton');
    installButton.style.display = 'block';

    installButton.addEventListener('click', (e) => {
    // Hide the install button
    installButton.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome === 'accepted') {
    console.log('User accepted the install prompt');
} else {
    console.log('User dismissed the install prompt');
}
});
});
}
