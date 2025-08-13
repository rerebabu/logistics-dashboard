import L from "leaflet";
import * as turf from "@turf/turf";
import "leaflet/dist/leaflet.css";

let map, warehouseMarker, marker, circle;

window.initMap = function (warehouseLat = 14.5995, warehouseLng = 120.9842) {
    // Create map
    map = L.map("map").setView([warehouseLat, warehouseLng], 14);

    // Base layer
    const base = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            attribution: "© OpenStreetMap contributors",
            maxZoom: 19,
        }
    ).addTo(map);

    // Warehouse marker
    warehouseMarker = L.marker([warehouseLat, warehouseLng])
        .addTo(map)
        .bindPopup("Warehouse")
        .openPopup();

    // Draw initial circle
    const start = [warehouseLat, warehouseLng];
    const pulseIcon = L.divIcon({ className: "pulse", iconSize: [14, 14] });

    marker = L.marker(start, { draggable: true, icon: pulseIcon }).addTo(map);
    circle = L.circle(start, {
        radius: getRadius(),
        color: "#22d3ee",
        weight: 2,
        fillOpacity: 0.08,
    }).addTo(map);

    // Marker drag events
    marker.on("drag", (e) => syncInputs(e.latlng));
    marker.on("dragend", (e) => syncInputs(e.target.getLatLng()));

    // Map click event
    map.on("click", (e) => {
        marker.setLatLng(e.latlng);
        syncInputs(e.latlng);
    });

    // Button controls
    document.getElementById("btnCenter")?.addEventListener("click", () => {
        map.setView(marker.getLatLng(), 15);
    });

    document.getElementById("btnSatellite")?.addEventListener("click", () => {
        base.setUrl("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png");
    });

    // Radius range control
    const range = document.getElementById("radiusRange");
    if (range) {
        range.addEventListener("input", () => {
            const r = getRadius();
            circle.setRadius(r);
            document.getElementById("radiusText").textContent = r;
            document.getElementById("radiusLabel").textContent = `${r} m`;
            document.getElementById("radiusHidden").value = r;
            updateAccuracyEstimate();
        });
    }

    // Sync inputs initially
    syncInputs(marker.getLatLng());
    updateAccuracyEstimate();

    // FIX: Delay resize check until container is fully ready
    setTimeout(() => {
        map.invalidateSize();
    }, 500);

    return map;
};

function getRadius() {
    const r = document.getElementById("radiusRange");
    return r ? Number(r.value) : 250;
}

function syncInputs({ lat, lng }) {
    const latInput = document.getElementById("lat");
    const lngInput = document.getElementById("lng");
    if (latInput) latInput.value = lat.toFixed(6);
    if (lngInput) lngInput.value = lng.toFixed(6);
    circle.setLatLng([lat, lng]);
}

function updateAccuracyEstimate() {
    const radius = getRadius();
    const acc = Math.max(92, 100 - (radius - 100) * 0.02);
    const el = document.getElementById("estAcc");
    if (el) el.textContent = `${acc.toFixed(1)}%`;
}

// Auto init when map element exists
document.addEventListener("DOMContentLoaded", () => {
    const mapEl = document.getElementById("map");
    if (mapEl) window.initMap();
});
