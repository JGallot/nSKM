nSKM
====

nSKM ( 'nother SSH Key Management ) is a LAMP application that enables a team of system administrators to centrally manage and deploy ssh keys.

This application is intended to be used in large environnements where access to unix accounts are handled with ssh keys (using passwords is BAD !)

nSKM allows you to centralize the public keys on one machine. You can organise these keys with groups of keys called keyrings.

nSKM will deploy the keys and/or keyrings to specified unix accounts.

nSKM is a fork of SKM (SSH Key Management) previously maintained by Jerome Boismartel (https://sites.google.com/site/jeromeboismartel)

Functionalities
===============

* Creating unix accoutns if asked
* Syncing list of Hosts from foreman