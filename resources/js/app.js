// Particles (very light background dots)
const canvas = document.getElementById("particles");
if (canvas) {
    const ctx = canvas.getContext("2d");
    let w, h, dots;
    const init = () => {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
        dots = Array.from({ length: Math.round((w * h) / 22000) }, () => ({
            x: Math.random() * w,
            y: Math.random() * h,
            r: Math.random() * 1.5 + 0.4,
            vx: (Math.random() - 0.5) * 0.15,
            vy: (Math.random() - 0.5) * 0.15,
        }));
    };
    const draw = () => {
        ctx.clearRect(0, 0, w, h);
        ctx.fillStyle = "rgba(255,255,255,0.15)";
        dots.forEach((d) => {
            d.x += d.vx;
            d.y += d.vy;
            if (d.x < 0 || d.x > w) d.vx *= -1;
            if (d.y < 0 || d.y > h) d.vy *= -1;
            ctx.beginPath();
            ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
            ctx.fill();
        });
        requestAnimationFrame(draw);
    };
    init();
    draw();
    window.addEventListener("resize", init);
}

// Reveal on scroll
const io = new IntersectionObserver(
    (entries) =>
        entries.forEach(
            (e) => e.isIntersecting && e.target.classList.add("reveal")
        ),
    { threshold: 0.08 }
);
document.querySelectorAll(".reveal").forEach((el) => io.observe(el));
