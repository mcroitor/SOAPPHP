rem generate certificate
openssl req -newkey rsa:2048 -nodes -keyout service_key.pem -x509 -days 365 -out service_certificate.pem

rem verify certificate
openssl x509 -text -noout -in service_certificate.pem

rem create p12
openssl pkcs12 -inkey service_key.pem -in service_certificate.pem -export -out service.p12

rem verify p12
openssl pkcs12 -in service.p12 -noout -info