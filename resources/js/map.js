import L from "leaflet";
import * as turf from "@turf/turf";
import "leaflet/dist/leaflet.css";

let map, warehouseMarker, circle, userInputMarker, deliveryMarker;

window.initMap = function (warehouseLat = 14.5995, warehouseLng = 120.9842) {
    // Create map
    map = L.map("map").setView([warehouseLat, warehouseLng], 14);

    // Base layer
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
        maxZoom: 19,
    }).addTo(map);

    // Warehouse marker
    warehouseMarker = L.marker([warehouseLat, warehouseLng])
        .addTo(map)
        .bindPopup("Warehouse")
        .openPopup();

    // Warehouse circle
    circle = L.circle([warehouseLat, warehouseLng], {
        radius: getRadius(),
        color: "#22d3ee",
        weight: 2,
        fillOpacity: 0.08,
    }).addTo(map);

    // Pulsing marker for draggable start point
    const pulseIcon = L.divIcon({ className: "pulse", iconSize: [14, 14] });

    const start = [warehouseLat, warehouseLng];
    const marker = L.marker(start, { draggable: true, icon: pulseIcon }).addTo(
        map
    );

    marker.on("drag", (e) => syncInputs(e.latlng));
    marker.on("dragend", (e) => syncInputs(e.target.getLatLng()));

    map.on("click", (e) => {
        marker.setLatLng(e.latlng);
        syncInputs(e.latlng);
    });

    // Buttons
    document.getElementById("btnCenter")?.addEventListener("click", () => {
        map.setView(marker.getLatLng(), 15);
    });

    document.getElementById("btnSatellite")?.addEventListener("click", () => {
        // Change tile style
        map.eachLayer((layer) => {
            if (layer instanceof L.TileLayer) {
                layer.setUrl(
                    "https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"
                );
            }
        });
    });

    // Radius slider
    const range = document.getElementById("radiusRange");
    if (range) {
        range.addEventListener("input", () => {
            const r = getRadius();
            circle.setRadius(r);
            document.getElementById("radiusLabel").textContent = `${r} m`;
            updateAccuracyEstimate();
        });
    }

    // Init inputs from draggable marker
    syncInputs(marker.getLatLng());
    updateAccuracyEstimate();

    // Fix map cut-off
    setTimeout(() => {
        map.invalidateSize();
    }, 300);

    return map;
};

// Get radius from slider
function getRadius() {
    const r = document.getElementById("radiusRange");
    return r ? Number(r.value) : 250;
}

// Update inputs & move circle
function syncInputs({ lat, lng }) {
    const latInput = document.getElementById("lat");
    const lngInput = document.getElementById("lng");

    if (latInput) latInput.value = lat.toFixed(6);
    if (lngInput) lngInput.value = lng.toFixed(6);

    circle.setLatLng([lat, lng]);
}

// Accuracy calculation
function updateAccuracyEstimate() {
    const radius = getRadius();
    const acc = Math.max(92, 100 - (radius - 100) * 0.02);
    const el = document.getElementById("estAcc");
    if (el) el.textContent = `${acc.toFixed(1)}%`;
}

window.showUserInputMarker = function (lat, lng) {
    if (!map) return;

    // Remove old marker if it exists
    if (userInputMarker) {
        map.removeLayer(userInputMarker);
    }

    // Create a red icon for user input
    const userIcon = L.icon({
        iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -25],
    });

    userInputMarker = L.marker([lat, lng], { icon: userIcon })
        .addTo(map)
        .bindPopup("User Input Location")
        .openPopup();

    // Optionally zoom to it
    map.setView([lat, lng], 15);
};

// Show delivery marker
window.updateDeliveryMarker = function (lat, lng, fitBounds = false) {
    if (!map) return;

    if (deliveryMarker) {
        map.removeLayer(deliveryMarker);
    }

    const deliveryIcon = L.icon({
        iconUrl: "/images/delivery-marker.png",
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -25],
    });

    deliveryMarker = L.marker([lat, lng], { icon: deliveryIcon })
        .addTo(map)
        .bindPopup("Delivery Location")
        .openPopup();

    if (fitBounds && warehouseMarker) {
        const group = L.featureGroup([warehouseMarker, deliveryMarker, circle]);
        map.fitBounds(group.getBounds().pad(0.3));
    }
};

// Auto-init if map container exists
document.addEventListener("DOMContentLoaded", () => {
    const mapEl = document.getElementById("map");
    if (mapEl) window.initMap();
});
