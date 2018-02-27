<?php

if (app()->environment() != 'testing') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.api.title')}}</title>
    <link rel="icon" type="image/png" href="{{asset(config('l5-swagger.paths.assets_public'))}}/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{asset(config('l5-swagger.paths.assets_public'))}}/images/favicon-16x16.png" sizes="16x16" />
    <link href='{{asset(config('l5-swagger.paths.assets_public'))}}/css/typography.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='{{asset(config('l5-swagger.paths.assets_public'))}}/css/reset.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='{{asset(config('l5-swagger.paths.assets_public'))}}/css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='{{asset(config('l5-swagger.paths.assets_public'))}}/css/reset.css' media='print' rel='stylesheet' type='text/css'/>
    <link href='{{asset(config('l5-swagger.paths.assets_public'))}}/css/print.css' media='print' rel='stylesheet' type='text/css'/>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/object-assign-pollyfill.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/jquery-1.8.0.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/jquery.slideto.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/jquery.wiggle.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/handlebars-2.0.0.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/lodash.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/backbone-min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/swagger-ui.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/highlight.9.1.0.pack.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/highlight.9.1.0.pack_extended.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/jsoneditor.min.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/marked.js' type='text/javascript'></script>
    <script src='{{asset(config('l5-swagger.paths.assets_public'))}}/lib/swagger-oauth.js' type='text/javascript'></script>

    <!-- Some basic translations -->
    <!-- <script src='lang/translator.js' type='text/javascript'></script> -->
    <!-- <script src='lang/ru.js' type='text/javascript'></script> -->
    <!-- <script src='lang/en.js' type='text/javascript'></script> -->

    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "{!! $urlToDocs !!}";
            }

            hljs.configure({
                highlightSizeThreshold: {{ $highlightThreshold }}
            });

            // Pre load translate...
            if(window.SwaggerTranslator) {
                window.SwaggerTranslator.translate();
            }
            
            $('ul.endpoints').show();

            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                @if(array_key_exists('validatorUrl', get_defined_vars()))
                // This differentiates between a null value and an undefined variable
                validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
                @endif
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function(swaggerApi, swaggerUi){
                    @if(isset($requestHeaders))
                    @foreach($requestHeaders as $requestKey => $requestValue)
                    window.swaggerUi.api.clientAuthorizations.add("{{$requestKey}}", new SwaggerClient.ApiKeyAuthorization("{{$requestKey}}", "{{$requestValue}}", "header"));
                    @endforeach
                            @endif

                    if(typeof initOAuth == "function") {
                        initOAuth({
                            clientId: "your-client-id",
                            clientSecret: "your-client-secret-if-required",
                            realm: "your-realms",
                            appName: "your-app-name",
                            scopeSeparator: ",",
                            additionalQueryStringParams: {}
                        });
                    }

                    if(window.SwaggerTranslator) {
                        window.SwaggerTranslator.translate();
                    }
                                $('ul.endpoints').show();

                },

                onFailure: function(data) {
                    console.log("Unable to Load SwaggerUI");
                },
                docExpansion: {!! isset($docExpansion) ? '"' . $docExpansion . '"' : '"none"' !!},
                jsonEditor: false,
                apisSorter: "alpha",
                defaultModelRendering: 'schema',
                showRequestHeaders: false
            });

            function addApiKeyAuthorization(){
                var key = $('#input_apiKey')[0].value;

                if ("{{$apiKeyInject}}" === "query") {
                    key = encodeURIComponent(key);
                }

                if(key && key.trim() != "") {
                    var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("{{$apiKeyVar}}", key, "{{$apiKeyInject}}");
                    window.swaggerUi.api.clientAuthorizations.add("{{$securityDefinition}}", apiKeyAuth);
                }
            }

            $('#input_apiKey').change(function() {
                addApiKeyAuthorization();
            });

            window.swaggerUi.load();

            // if you have an apiKey you would like to pre-populate on the page for demonstration purposes
            // just put it in the .env file, API_AUTH_TOKEN variable
            @if($apiKey)
            $('#input_apiKey').val("{{$apiKey}}");
            addApiKeyAuthorization();
            @endif
        });
    </script>
</head>

<body class="swagger-section">
<div id='header'>
    <div class="swagger-ui-wrap">
        
        <a id="logo" href="http://swagger.io">swagger</a>
        <form id='api_selector'>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
            <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
            <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
        </form>
    </div>
</div>

<div class="swagger-ui-wrap">
    <h1>Watheq API's Docs </h1>
    <div class='api-doc'>
        <p>All API'S use Content Type application/json request body.</p>
        <p>
            You must send "X-Api-Key: OPERATING_API_KEY" in header when calling any services.
            <br />
            <pre>
            Android Key "U2F0PDe4bSEQzBMi2SET8xaMNSB8amET" <br />
            IOS Key "85BCbm7U7JsQdbB5Z95vmvN4LyQmqVxp"
            </pre>
            <br />
        </p>
        <h3><u>General Errors</u></h3>
        <p>
            Sending invalid JSON will result in a 400 Bad Request response. 
            <pre>
                {
                    "code": 400,
                    "status": "error",
                    "message": "Invalid json format",
                    "errors": null
                }
            </pre>
        </p>
        <p>
            Sending Invalid API Key will result in a 403 Forbidden response. 
            <pre>
                {
                    "code": 403,
                    "status": "error",
                    "message": "Invalid API Key"
                    "errors": null
                }
            </pre>
        </p>
        <p>You must send "Authorization: Bearer LOGIN_ACCESS_TOKEN" in header when calling any services required authentication - with auth in URL.</p>
        <p>
            <pre>
                {
                    "code": 401,
                    "status": "error",
                    "message": "Invalid credentials"
                    "errors": null
                }
            </pre>
        </p>
        <p>
            All API's validation errors responses return json like this  
            <br />
            <pre>
                {
                    "status": "error",
                    "code": 405,
                    "message": "Invalid input",
                    "errors": [
                        "name is required"
                        "password is required"
                    ]
                }
            </pre>
        </p>
        <h1>
            <u>
                <a target="_blank" class="text-warning" href="{{url('order/log')}}">Check order requests status</a>
            </u>
        </h1>
        
        <h1>
            <u>
                <a target="_blank" class="text-warning" href="{{url('terms')}}">Terms web page</a>
            </u>
            <br />
            <u>
                <a target="_blank" class="text-warning" href="{{url('policy')}}">policy web page</a>
            </u>
            <u>
                <a target="_blank" class="text-warning" href="{{url('questions')}}">Questions page</a>
            </u>
        </h1>
    </div>
</div>
<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>


</body>
</html>
