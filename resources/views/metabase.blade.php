<!DOCTYPE html>
<html>
<head>
    <title>Metabase Embed</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 100vh;
            border: 0;
        }

        /* Adjust the iframe height for smaller screens */
        @media screen and (max-width: 768px) {
            iframe {
                height: 80vh;
            }
        }

        /* Adjust the iframe height for even smaller screens */
        @media screen and (max-width: 576px) {
            iframe {
                height: 60vh;
            }
        }
    </style>
</head>
<body>
    <iframe src="{{ $iframeUrl }}"></iframe>
</body>
</html>
