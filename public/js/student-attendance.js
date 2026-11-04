document.addEventListener('DOMContentLoaded', function () {
    /*
    |--------------------------------------------------------------------------
    | Camera Sessions
    |--------------------------------------------------------------------------
    |
    | Each Time In / Time Out form gets its own webcam session.
    |
    */

    const cameraSessions = new Map();


    /*
    |--------------------------------------------------------------------------
    | Initialize Camera Components
    |--------------------------------------------------------------------------
    */

    const cameraContainers = document.querySelectorAll(
        '[data-camera-container]'
    );

    cameraContainers.forEach(function (container) {
        const cameraId = container.dataset.cameraContainer;

        const video = container.querySelector(
            '[data-camera-video]'
        );

        const canvas = container.querySelector(
            '[data-camera-canvas]'
        );

        const fileInput = container.querySelector(
            '[data-selfie-input]'
        );

        const preview = container.querySelector(
            '[data-selfie-preview]'
        );

        const openButton = container.querySelector(
            '[data-camera-open]'
        );

        const captureButton = container.querySelector(
            '[data-camera-capture]'
        );

        const closeButton = container.querySelector(
            '[data-camera-close]'
        );

        const retakeButton = container.querySelector(
            '[data-camera-retake]'
        );

        const cameraArea = container.querySelector(
            '[data-camera-area]'
        );

        const status = container.querySelector(
            '[data-camera-status]'
        );

        /*
        |--------------------------------------------------------------------------
        | Open Camera
        |--------------------------------------------------------------------------
        */

        if (openButton) {
            openButton.addEventListener(
                'click',
                async function () {
                    await openCamera(
                        cameraId,
                        video,
                        cameraArea,
                        status,
                        captureButton,
                        closeButton
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Capture Selfie
        |--------------------------------------------------------------------------
        */

        if (captureButton) {
            captureButton.addEventListener(
                'click',
                async function () {
                    await captureSelfie({
                        cameraId,
                        video,
                        canvas,
                        fileInput,
                        preview,
                        cameraArea,
                        status,
                        captureButton,
                        closeButton,
                        retakeButton,
                    });
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Close Camera
        |--------------------------------------------------------------------------
        */

        if (closeButton) {
            closeButton.addEventListener(
                'click',
                function () {
                    stopCamera(cameraId);

                    if (cameraArea) {
                        cameraArea.hidden = true;
                    }

                    captureButton.hidden = true;
                    closeButton.hidden = true;
                    openButton.hidden = false;

                    setCameraStatus(
                        status,
                        'Camera closed.',
                        false
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Retake Selfie
        |--------------------------------------------------------------------------
        */

        if (retakeButton) {
            retakeButton.addEventListener(
                'click',
                async function () {
                    /*
                    |----------------------------------------------------------
                    | Clear Current Captured Selfie
                    |----------------------------------------------------------
                    */

                    if (fileInput) {
                        fileInput.value = '';
                    }

                    if (preview) {
                        preview.removeAttribute('src');
                        preview.hidden = true;
                    }

                    retakeButton.hidden = true;

                    /*
                    |----------------------------------------------------------
                    | Reopen Camera
                    |----------------------------------------------------------
                    */

                    await openCamera(
                        cameraId,
                        video,
                        cameraArea,
                        status,
                        captureButton,
                        closeButton
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Manual File Upload Fallback
        |--------------------------------------------------------------------------
        |
        | If the Student chooses a selfie file instead of using the webcam,
        | preview the selected image.
        |
        */

        if (fileInput) {
            fileInput.addEventListener(
                'change',
                function () {
                    const file = fileInput.files?.[0];

                    if (!file) {
                        return;
                    }

                    showFilePreview(
                        file,
                        preview
                    );

                    if (retakeButton) {
                        retakeButton.hidden = false;
                    }

                    setCameraStatus(
                        status,
                        'Selfie selected successfully.',
                        false
                    );
                }
            );
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Open Webcam
    |--------------------------------------------------------------------------
    */

    async function openCamera(
        cameraId,
        video,
        cameraArea,
        status,
        captureButton,
        closeButton
    ) {
        /*
        |--------------------------------------------------------------------------
        | Secure Context Check
        |--------------------------------------------------------------------------
        */

        if (!window.isSecureContext) {
            setCameraStatus(
                status,
                'Camera access requires HTTPS or localhost/127.0.0.1.',
                true
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Browser Support
        |--------------------------------------------------------------------------
        */

        if (
            !navigator.mediaDevices
            || !navigator.mediaDevices.getUserMedia
        ) {
            setCameraStatus(
                status,
                'Your browser does not support webcam access.',
                true
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Stop Existing Stream
        |--------------------------------------------------------------------------
        */

        stopCamera(cameraId);

        setCameraStatus(
            status,
            'Requesting camera permission...',
            false
        );

        try {
            /*
            |--------------------------------------------------------------------------
            | Request Front Camera
            |--------------------------------------------------------------------------
            */

            const stream =
                await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',

                        width: {
                            ideal: 1280,
                        },

                        height: {
                            ideal: 720,
                        },
                    },

                    audio: false,
                });

            cameraSessions.set(
                cameraId,
                stream
            );

            video.srcObject = stream;

            await video.play();

            /*
            |--------------------------------------------------------------------------
            | Show Camera
            |--------------------------------------------------------------------------
            */

            cameraArea.hidden = false;
            captureButton.hidden = false;
            closeButton.hidden = false;

            const openButton =
                document.querySelector(
                    `[data-camera-container="${cameraId}"] [data-camera-open]`
                );

            if (openButton) {
                openButton.hidden = true;
            }

            setCameraStatus(
                status,
                'Camera is ready. Position your face clearly and press Capture Selfie.',
                false
            );
        } catch (error) {
            console.error(
                'Camera error:',
                error
            );

            setCameraStatus(
                status,
                getCameraErrorMessage(error),
                true
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Capture Selfie From Video
    |--------------------------------------------------------------------------
    */

    async function captureSelfie({
        cameraId,
        video,
        canvas,
        fileInput,
        preview,
        cameraArea,
        status,
        captureButton,
        closeButton,
        retakeButton,
    }) {
        if (
            !video
            || video.readyState < 2
        ) {
            setCameraStatus(
                status,
                'Camera is not ready yet. Please wait a moment.',
                true
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Determine Image Size
        |--------------------------------------------------------------------------
        */

        const width =
            video.videoWidth || 1280;

        const height =
            video.videoHeight || 720;

        canvas.width = width;
        canvas.height = height;

        const context =
            canvas.getContext('2d');

        if (!context) {
            setCameraStatus(
                status,
                'Unable to capture the selfie.',
                true
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Draw Camera Frame
        |--------------------------------------------------------------------------
        */

        context.drawImage(
            video,
            0,
            0,
            width,
            height
        );

        /*
        |--------------------------------------------------------------------------
        | Convert Canvas to JPEG File
        |--------------------------------------------------------------------------
        */

        const blob = await canvasToBlob(
            canvas,
            'image/jpeg',
            0.9
        );

        if (!blob) {
            setCameraStatus(
                status,
                'Unable to create the selfie image.',
                true
            );

            return;
        }

        const timestamp =
            new Date()
                .toISOString()
                .replace(
                    /[:.]/g,
                    '-'
                );

        const selfieFile = new File(
            [blob],
            `ojt-selfie-${timestamp}.jpg`,
            {
                type: 'image/jpeg',
                lastModified: Date.now(),
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Put Captured File Into File Input
        |--------------------------------------------------------------------------
        |
        | This makes Laravel receive the webcam photo exactly like a normal
        | uploaded file with the field name "selfie".
        |
        */

        const dataTransfer =
            new DataTransfer();

        dataTransfer.items.add(
            selfieFile
        );

        fileInput.files =
            dataTransfer.files;

        /*
        |--------------------------------------------------------------------------
        | Show Captured Preview
        |--------------------------------------------------------------------------
        */

        showFilePreview(
            selfieFile,
            preview
        );

        /*
        |--------------------------------------------------------------------------
        | Stop Camera
        |--------------------------------------------------------------------------
        */

        stopCamera(cameraId);

        cameraArea.hidden = true;
        captureButton.hidden = true;
        closeButton.hidden = true;

        const openButton =
            document.querySelector(
                `[data-camera-container="${cameraId}"] [data-camera-open]`
            );

        if (openButton) {
            openButton.hidden = false;
        }

        if (retakeButton) {
            retakeButton.hidden = false;
        }

        setCameraStatus(
            status,
            'Selfie captured successfully.',
            false
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Stop Camera Stream
    |--------------------------------------------------------------------------
    */

    function stopCamera(cameraId) {
        const stream =
            cameraSessions.get(cameraId);

        if (!stream) {
            return;
        }

        stream
            .getTracks()
            .forEach(function (track) {
                track.stop();
            });

        cameraSessions.delete(
            cameraId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Convert Canvas To Blob
    |--------------------------------------------------------------------------
    */

    function canvasToBlob(
        canvas,
        type,
        quality
    ) {
        return new Promise(
            function (resolve) {
                canvas.toBlob(
                    resolve,
                    type,
                    quality
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Preview Selfie
    |--------------------------------------------------------------------------
    */

    function showFilePreview(
        file,
        preview
    ) {
        if (!preview) {
            return;
        }

        const objectUrl =
            URL.createObjectURL(file);

        preview.src =
            objectUrl;

        preview.hidden =
            false;

        preview.onload =
            function () {
                URL.revokeObjectURL(
                    objectUrl
                );
            };
    }


    /*
    |--------------------------------------------------------------------------
    | Camera Error Messages
    |--------------------------------------------------------------------------
    */

    function getCameraErrorMessage(
        error
    ) {
        if (!error) {
            return 'Unable to open the camera.';
        }

        switch (error.name) {
            case 'NotAllowedError':

                return 'Camera permission was denied. Please allow camera access in Chrome and try again.';

            case 'NotFoundError':

                return 'No camera was detected on this device.';

            case 'NotReadableError':

                return 'The camera is already being used by another application or browser tab.';

            case 'OverconstrainedError':

                return 'Your camera does not support the requested settings.';

            case 'SecurityError':

                return 'Camera access was blocked for security reasons.';

            default:

                return 'Unable to access the camera. Check your browser camera permissions.';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Camera Status
    |--------------------------------------------------------------------------
    */

    function setCameraStatus(
        element,
        message,
        isError
    ) {
        if (!element) {
            return;
        }

        element.textContent =
            message;

        element.classList.toggle(
            'camera-error',
            isError
        );

        element.classList.toggle(
            'camera-success',
            !isError
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GPS Attendance Forms
    |--------------------------------------------------------------------------
    */

    const attendanceForms =
        document.querySelectorAll(
            '[data-gps-form]'
        );

    attendanceForms.forEach(
        function (form) {
            const status =
                form.querySelector(
                    '[data-gps-status]'
                );

            const submitButton =
                form.querySelector(
                    '[data-submit-button]'
                );

            form.addEventListener(
                'submit',
                async function (event) {
                    /*
                    |--------------------------------------------------------------------------
                    | GPS Already Captured
                    |--------------------------------------------------------------------------
                    */

                    if (
                        form.dataset.gpsReady
                        === 'true'
                    ) {
                        return;
                    }

                    event.preventDefault();

                    /*
                    |--------------------------------------------------------------------------
                    | Require Selfie
                    |--------------------------------------------------------------------------
                    */

                    const selfie =
                        form.querySelector(
                            'input[name="selfie"]'
                        );

                    if (
                        !selfie
                        || !selfie.files
                        || selfie.files.length === 0
                    ) {
                        setGpsStatus(
                            status,
                            'Please capture or select a selfie first.',
                            true
                        );

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Secure Context
                    |--------------------------------------------------------------------------
                    */

                    if (!window.isSecureContext) {
                        setGpsStatus(
                            status,
                            'GPS requires HTTPS or localhost/127.0.0.1.',
                            true
                        );

                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | GPS Support
                    |--------------------------------------------------------------------------
                    */

                    if (!navigator.geolocation) {
                        setGpsStatus(
                            status,
                            'Your browser does not support GPS location.',
                            true
                        );

                        return;
                    }

                    if (submitButton) {
                        submitButton.disabled =
                            true;

                        submitButton.textContent =
                            'Capturing GPS...';
                    }

                    setGpsStatus(
                        status,
                        'Requesting your current GPS location...',
                        false
                    );

                    try {
                        const position =
                            await getCurrentPosition();

                        const latitude =
                            position.coords.latitude;

                        const longitude =
                            position.coords.longitude;

                        const accuracy =
                            position.coords.accuracy;

                        /*
                        |--------------------------------------------------------------------------
                        | Fill Hidden Inputs
                        |--------------------------------------------------------------------------
                        */

                        form.querySelector(
                            'input[name="latitude"]'
                        ).value = latitude;

                        form.querySelector(
                            'input[name="longitude"]'
                        ).value = longitude;

                        form.querySelector(
                            'input[name="accuracy"]'
                        ).value = accuracy;

                        setGpsStatus(
                            status,
                            `GPS captured successfully. Estimated accuracy: ${Math.round(accuracy)} meters.`,
                            false
                        );

                        form.dataset.gpsReady =
                            'true';

                        if (submitButton) {
                            submitButton.textContent =
                                'Saving Attendance...';
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Submit To Laravel
                        |--------------------------------------------------------------------------
                        */

                        form.submit();
                    } catch (error) {
                        form.dataset.gpsReady =
                            'false';

                        if (submitButton) {
                            submitButton.disabled =
                                false;

                            submitButton.textContent =
                                submitButton
                                    .dataset
                                    .originalText
                                || 'Submit Attendance';
                        }

                        setGpsStatus(
                            status,
                            getGpsErrorMessage(
                                error
                            ),
                            true
                        );
                    }
                }
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | GPS Promise
    |--------------------------------------------------------------------------
    */

    function getCurrentPosition() {
        return new Promise(
            function (resolve, reject) {
                navigator.geolocation
                    .getCurrentPosition(
                        resolve,
                        reject,
                        {
                            enableHighAccuracy:
                                true,

                            timeout:
                                20000,

                            maximumAge:
                                0,
                        }
                    );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GPS Errors
    |--------------------------------------------------------------------------
    */

    function getGpsErrorMessage(
        error
    ) {
        if (!error) {
            return 'Unable to retrieve your GPS location.';
        }

        switch (error.code) {
            case 1:

                return 'Location permission was denied. Please allow location access and try again.';

            case 2:

                return 'Your location could not be determined. Make sure Windows Location Services are enabled.';

            case 3:

                return 'GPS request timed out. Please try again.';

            default:

                return 'Unable to retrieve your GPS location.';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GPS Status
    |--------------------------------------------------------------------------
    */

    function setGpsStatus(
        element,
        message,
        isError
    ) {
        if (!element) {
            return;
        }

        element.textContent =
            message;

        element.classList.toggle(
            'gps-error',
            isError
        );

        element.classList.toggle(
            'gps-success',
            !isError
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Stop Cameras Before Leaving Page
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        function () {
            cameraSessions.forEach(
                function (stream) {
                    stream
                        .getTracks()
                        .forEach(
                            function (track) {
                                track.stop();
                            }
                        );
                }
            );

            cameraSessions.clear();
        }
    );
});