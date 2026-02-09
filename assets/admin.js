document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('input[name$="[coordsInput]"]');
    const latInput = document.querySelector('input[name$="[lat]"]');
    const lngInput = document.querySelector('input[name$="[lng]"]');

    if (!input || !latInput || !lngInput) return;

    input.addEventListener('change', () => {
        const value = input.value.trim();
        const match = value.match(
            /([\d.]+)\s*[NnSs]\s*,\s*([\d.]+)\s*[EeWw]/
        );

        if (!match) return;
        let lat = parseFloat(match[1]);
        let lng = parseFloat(match[2]);

        // zaokrouhlení na 3 desetinná místa
        lat = lat.toFixed(3);
        lng = lng.toFixed(3);

        latInput.value = lat;
        lngInput.value = lng;
    });
});