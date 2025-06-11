document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".tab").forEach(tab => {
        tab.addEventListener("click", () => {
            document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
            document.querySelectorAll(".user_detail").forEach(detail => detail.style.display = "none");

            tab.classList.add("active");
            const target = tab.getAttribute("data-target");
            document.getElementById(target).style.display = "block";
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const planetElement = document.querySelector('.planet-id');

    if (!planetElement) {
        console.error('No .planet-id element found.');
        return;
    }

    const fetchBookedSeats = (planetId) => {
        fetch('./content/booking.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: planetId })
        })
        .then(response => response.json())
        .then(bookedSeats => {
            document.querySelectorAll('.seat').forEach(seat => {
                seat.classList.remove('booked');
                const seatNum = seat.getAttribute('data-seat');
                seat.querySelector('h4').textContent = `Seat ${seatNum}`;
            });

            bookedSeats.forEach(seat => {
                const seatEl = document.querySelector(`.seat[data-seat="${seat.seat_number}"]`);
                if (seatEl) {
                    seatEl.classList.add('booked');
                    seatEl.querySelector('h4').textContent = seat.username || `Seat ${seat.seat_number}`;
                }
            });
        })
        .catch(err => console.error('Error fetching seat data:', err));
    };

    const observer = new MutationObserver(mutations => {
        for (const mutation of mutations) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'id') {
                console.log('[ID changed]', planetElement.id);
                fetchBookedSeats(planetElement.id);
            }
        }
    });

    observer.observe(planetElement, { attributes: true, attributeFilter: ['id'] });
    fetchBookedSeats(planetElement.id || 'p_earth');
});