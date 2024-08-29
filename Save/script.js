let map;
let markers = [];

function initMap() {
    const center = { lat: 23.5, lng: 120.5 };
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: center
    });

    fetch('/get_restaurants.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(restaurant => {
                const marker = new google.maps.Marker({
                    position: { lat: restaurant.latitude, lng: restaurant.longitude },
                    map: map,
                    title: restaurant.name
                });
                markers.push(marker);

                const infoWindow = new google.maps.InfoWindow({
                    content: `<h3>${restaurant.name}</h3><p>${restaurant.description}</p>`
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                const restaurantDiv = document.createElement('div');
                restaurantDiv.className = 'restaurant';
                restaurantDiv.innerHTML = `<h4>${restaurant.name}</h4><p>${restaurant.description}</p>`;
                document.getElementById('restaurant-list').appendChild(restaurantDiv);
            });
        });

    fetch('/get_meal_plans.php?user_id=1')
        .then(response => response.json())
        .then(data => {
            const mealPlansDiv = document.getElementById('meal-plans');
            data.forEach(plan => {
                const mealPlanDiv = document.createElement('div');
                mealPlanDiv.className = 'meal-plan';
                mealPlanDiv.innerHTML = `<h4>${plan.name}</h4><p>${plan.address} - ${plan.meal_date}</p>`;
                mealPlansDiv.appendChild(mealPlanDiv);
            });
        });
}
