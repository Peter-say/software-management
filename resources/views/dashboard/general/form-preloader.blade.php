<style>
    /* Overlay to cover full screen */
    .preloader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
        background: rgba(255, 255, 255, 0.8);
        /* Light transparent background */
        display: flex;
        align-items: center;
        justify-content: center;
        display: none;
        /* hidden by default */
    }

    /* Ripple animation */
    .form-lds-ripple {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .form-lds-ripple div {
        position: absolute;
        border: 4px solid #007bff;
        opacity: 1;
        border-radius: 50%;
        animation: form-lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    .form-lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes form-lds-ripple {
        0% {
            top: 36px;
            left: 36px;
            width: 0;
            height: 0;
            opacity: 1;
        }

        100% {
            top: 0px;
            left: 0px;
            width: 72px;
            height: 72px;
            opacity: 0;
        }
    }
</style>
<!-- Preloader -->
<div id="form-preloader" class="preloader-overlay">
    <div class="form-lds-ripple">
        <div></div>
        <div></div>
    </div>
</div>
