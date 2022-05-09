# URL ID GENERATOR

This project consist the tests and algorithms which help to generate an bigint id for any given url. 

#### Steps to run the application

- clone the project
- enter into the root folder of the application
- please run the test cases by executing following command:
	1. php .\vendor\bin\phpunit tests\Network\NewPhpUrlIdGeneratorTest.php
	2. php .\vendor\bin\phpunit tests\Network\PhpUrlIdGeneratorTest.php

#### Step to setup the database
- Modify the database configuration from
   File-Path: src/Config/database.php 
- create the new database(url_encoder) :
   >> CREATE DATABASE url_encoder;. 

#### What we should do for caching?

- We can use phpfastcache or some similar cache in which url would be the key but inbuild caches has restriction for the naming convention of the key for example we cannot use :()[] etc.
   - one possible solution to the above restriction could be url encoding, we can encode the url so that it won't containts the restricted special characters anymore.
- We could use an multidimentional array as cache in which we will consist the multiple dimensions based on below important parameters:
      - First dimension could be based on protocol such as http/https
      - Second dimension could be based on domain type such as .com, .org etc
      - Third dimension could be the website main name , for example google from www.google.com
      - Similarly we can add more if require and it makesenes.
      **I don't believe in reinventing the wheel until we have very valid reason to do that. I also understand that there are pros and cons which needs to be consider beforehand**
      - An sample overview:
         [
            https => [it => [google => [actual_url => url id]]],
            http => [de => [amazon => [actual_url => url id]]]
         ]

#### What we can improve?

- I agree that there are still lots of opportunity to refector & clean the code along with custom exception handling etc.

#### What's left?

- There are few test which are still failing because i was unable to identify the pattern to generate the ids however i tried N number of permutation and combinations. I would be really happy to fix them if you wouldn't mind to share the pattern.
  Example:
  
   http://www.jobscout24.ch/de/jobs/?ft=\\permamed ag\\"	|	1417636970406211536
   http://www.seafight.cz/24?aid=579&aip=\\[creative}	|	12456070874743718931
   http://www.marieclairemaison.com/,un-vrai-petit-jardin-sur-un-balcon,200226,413.asp?xtor=EPR-3-\\[06/07/14\\]	|	8853975105837344975
