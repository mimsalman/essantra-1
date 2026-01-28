import './bootstrap';
document.addEventListener("DOMContentLoaded", () => {
    // Card number: digits only + spaces every 4
    const cardNumber = document.getElementById("card_number");
    if (cardNumber) {
        cardNumber.addEventListener("input", (e) => {
            let v = e.target.value.replace(/\D/g, "").slice(0, 16);
            e.target.value = v.replace(/(.{4})/g, "$1 ").trim();
        });
    }

    // Expiry: MM/YY with auto slash and valid month
    const cardExpiry = document.getElementById("card_expiry");
    if (cardExpiry) {
        cardExpiry.addEventListener("input", (e) => {
            let v = e.target.value.replace(/\D/g, "").slice(0, 4); // MMYY

            if (v.length >= 3) v = v.slice(0, 2) + "/" + v.slice(2);

            // Fix month if user types >12 or 00
            if (v.length >= 2) {
                let mm = parseInt(v.slice(0, 2), 10);
                if (!isNaN(mm)) {
                    if (mm === 0) mm = 1;
                    if (mm > 12) mm = 12;
                    v = String(mm).padStart(2, "0") + v.slice(2);
                }
            }

            e.target.value = v;
        });
    }

    // CVC: digits only max 4
    const cardCvc = document.getElementById("card_cvc");
    if (cardCvc) {
        cardCvc.addEventListener("input", (e) => {
            e.target.value = e.target.value.replace(/\D/g, "").slice(0, 4);
        });
    }

    // Name on card: letters + spaces only (optional)
    const cardName = document.getElementById("card_name");
    if (cardName) {
        cardName.addEventListener("input", (e) => {
            e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, "");
        });
    }
});
