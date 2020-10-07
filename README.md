# SMSAPI - moduł do Magento 2
Prosty moduł do powiadamiania SMS-em (za pośrednictwem serwisu SMSAPI.pl) o zdarzeniach w zamówieniach w Magento 2.

###Instrucja uruchomienia

```
git clone git@github.com:dawidofed/smsapi.git app/code/StudioIt
```

Dzięki temu w app/code/StudioIt pojawi się kod modułu.
Teraz pobieramy oficjalną bibliotekę smsapi.

```
composer require smsapi/php-client
```

Przyszedł czas na uruchomienie:

```
bin/magento cache:clear
bin/magento module:enable StudioIt_Smsapi
bin/magento setup:upgrade
bin/magento setup:di:compile
```

Wszystkie ustawienia modułu znajdują się w "Stores" -> "Configuration" -> "Studio IT - module settings".

###Licencja

Moduł do dowolnego stosowania, można do woli przerabiać. :)
A jeśli ktoś potrzebuje pomocy w jego przerobieniu na swoje potrzeby, zawsze może się ze mną skontaktować.



