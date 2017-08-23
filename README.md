# UuidGuid

Functions written in PHP that generates UUIDS. 

------------------------------------------------------------------------------------------------------------------------------------------

The first function, which was created by Andrew Moore in http://www.php.net/manual/en/function.uniqid.php#94959 , is in compliance with RFC 4122.

The second function in the file generates a pseudo-random, "pseudo-version4-uuid".
There are a few positions in a version four UUID that should be filled with pre-defined characters, but the second function generates random numbers for all positions in the UUID.

-----------------------------------------------------------------------------------------------------------------------------------------

# CONSIDERATIONS

The functions were developed to work in plain PHP projects, but might work with PHP Frameworks, like Laravel.

Since the functions uses rand(), mt_rand() or similar functions to generate the UUIDs, the randomness of the generated UUIDs are NOT GUARANTEED TO BE UNIQUE.

If your project just demands a random generated number to fill an UUID number, but you don't need it to be an unique key number, feel free to use these functions.

If your projects demand uniqueness and "cryptographical" key fields, there is no guarantee that these functions will generate safe UUIDs.

------------------------------------------------------------------------------------------------------------------------------------------

FEEL FREE TO CHANGE THE CODE AT WILL

------------------------------------------------------------------------------------------------------------------------------------------

Gustavo Felício
