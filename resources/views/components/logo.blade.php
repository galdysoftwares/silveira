<style>
    .sparkle {
        background: linear-gradient(45deg,#F8CA00,#fe7496);
        mask:
            radial-gradient(#0000 71%,#F8CA00 72% var(--_b,))
            10000% 10000%/99.5% 99.5%;
        }
    .border {
        --b: 10px; /* control the thickness */
        --_b: calc(71% + var(--b)),#0000 calc(72% + var(--b));
    }
</style>

<div class="sparkle border w-10 h-10"></div>
