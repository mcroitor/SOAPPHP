rem generate certificate
openssl req -newkey rsa:2048 -nodes -keyout client_key.pem -x509 -days 365 -out client_certificate.pem

rem verify certificate
openssl x509 -text -noout -in client_certificate.pem

rem create p12
openssl pkcs12 -inkey client_key.pem -in client_certificate.pem -export -out client.p12

rem verify p12
openssl pkcs12 -in client.p12 -noout -info