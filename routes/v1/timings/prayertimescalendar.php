<?php

use Api\Controllers;
use Slim\Routing\RouteCollectorProxy;

$app->group('/v1', function(RouteCollectorProxy $group) {
    /**
     * @api {get} http://api.aladhan.com/v1/calendar/:year/:month Prayer Times Calendar
     * @apiDescription Returns all prayer times for a specific calendar month.
     * @apiName GetCalendar
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiQuery {decimal} latitude The decimal value for the latitude co-ordinate of the location you want the time computed for. Example: 51.75865125
     * @apiQuery {decimal} longitude The decimal value for the longitude co-ordinate of the location you want the time computed for. Example: -1.25387785
     * @apiParam {number=1-12} month Optional. A gregorian calendar month. Example: 8 or 08 for August. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A gregorian calendar year. Example: 2014.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               17 - JAKIM, Malaysia<br />
     *                               18 - Tunisia
     *                               19 - Algeria
     *                               20 - KEMENAG, Indonesia
     *                               21 - Morocco
     *                               22 - Portugal
     *                               23 - Jordan
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {string} [timezonestring] A valid timezone name as specified on <a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a>  . Example: Europe/London. If you do not specify this, we'll calcuate it using the co-ordinates you provide.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/calendar/2017/4?latitude=51.508515&longitude=-0.1254872&method=2
     *   http://api.aladhan.com/v1/calendar/2019?latitude=51.508515&longitude=-0.1254872&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/calendar', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);
    $group->map(['GET', 'OPTIONS'],'/calendar/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);
    $group->map(['GET', 'OPTIONS'],'/calendar/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);

    /**
     * @api {get} http://api.aladhan.com/v1/calendarByAddress/:year/:month Prayer Times Calendar by address
     * @apiDescription Returns all prayer times for a specific calendar month at a particular address.
     * @apiName GetCalendarByAddress
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiQuery {string} address An address string. Example: 1420 Austin Bluffs Parkway, Colorado Springs, CO OR 25 Hampstead High Street, London, NW3 1RL, United Kingdom OR Sultanahmet Mosque, Istanbul, Turkey
     * @apiParam {number=1-12} month Optional. A gregorian calendar month. Example: 8 or 08 for August. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A gregorian calendar year. Example: 2014.
     * @apiQuery {string} x7xapikey An API key from https://7x.ax to geocode the address. If you do not provide one the response will mask the geocoded co-ordinates.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               17 - JAKIM, Malaysia<br />
     *                               18 - Tunisia
     *                               19 - Algeria
     *                               20 - KEMENAG, Indonesia
     *                               21 - Morocco
     *                               22 - Portugal
     *                               23 - Jordan
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/calendarByAddress/2017/4?address=Sultanahmet Mosque, Istanbul, Turkey&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/calendarByAddress', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);
    $group->map(['GET', 'OPTIONS'],'/calendarByAddress/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);
    $group->map(['GET', 'OPTIONS'],'/calendarByAddress/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);

    /**
     * @api {get} http://api.aladhan.com/v1/calendarByCity/:year/:month Prayer Times Calendar by city
     * @apiDescription Returns all prayer times for a specific calendar month by City.
     * @apiName GetCalendarByCitys
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiParam {number=1-12} month Optional. A gregorian calendar month. Example: 8 or 08 for August. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A gregorian calendar year. Example: 2014.
     * @apiQuery {string} city A city name. Example: London
     * @apiQuery {string} country A country name or 2 character alpha ISO 3166 code. Examples: GB or United Kindom
     * @apiQuery {string} [state] State or province. A state name or abbreviation. Examples: Colorado / CO / Punjab / Bengal
     * @apiQuery {string} x7xapikey An API key from https://7x.ax to geocode the city and country. If you do not provide one the response will mask the geocoded co-ordinates.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               17 - JAKIM, Malaysia<br />
     *                               18 - Tunisia
     *                               19 - Algeria
     *                               20 - KEMENAG, Indonesia
     *                               21 - Morocco
     *                               22 - Portugal
     *                               23 - Jordan
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/calendarByCity/2017/4?city=London&country=United Kingdom&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/calendarByCity', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);
    $group->map(['GET', 'OPTIONS'],'/calendarByCity/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);
    $group->map(['GET', 'OPTIONS'],'/calendarByCity/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);

    /**
     * @api {get} http://api.aladhan.com/v1/hijriCalendar/:year/:month Prayer Times Hijri Calendar
     * @apiDescription Returns all prayer times for a specific Hijri calendar month.
     * @apiName GetHijriCalendar
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiQuery {decimal} latitude The decimal value for the latitude co-ordinate of the location you want the time computed for. Example: 51.75865125
     * @apiQuery {decimal} longitude The decimal value for the longitude co-ordinate of the location you want the time computed for. Example: -1.25387785
     * @apiParam {number=1-12} month Optional. A Hijri calendar month. Example: 9 or 09 for Ramadan. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A Hijri calendar year. Example: 1437.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {string} [timezonestring] A valid timezone name as specified on <a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a>  . Example: Europe/London. If you do not specify this, we'll calcuate it using the co-ordinates you provide.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/hijriCalendar/1437/4?latitude=51.508515&longitude=-0.1254872&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/hijriCalendar', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendar/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendar/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendar']);

    /**
     * @api {get} http://api.aladhan.com/v1/hijriCalendarByAddress/:year/:month Prayer Times Hijri Calendar by address
     * @apiDescription Returns all prayer times for a specific Hijri calendar month at a particular address.
     * @apiName GetHijriCalendarByAddress
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiQuery {string} address An address string. Example: 1420 Austin Bluffs Parkway, Colorado Springs, CO OR 25 Hampstead High Street, London, NW3 1RL, United Kingdom OR Sultanahmet Mosque, Istanbul, Turkey
     * @apiParam {number=1-12} month Optional. A Hijri calendar month. Example: 9 or 09 for Ramadan. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A Hijri calendar year. Example: 1437.
     * @apiQuery {string} x7xapikey An API key from https://7x.ax to geocode the address. If you do not provide one the response will mask the geocoded co-ordinates.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               17 - JAKIM, Malaysia<br />
     *                               18 - Tunisia
     *                               19 - Algeria
     *                               20 - KEMENAG, Indonesia
     *                               21 - Morocco
     *                               22 - Portugal
     *                               23 - Jordan
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/hijriCalendarByAddress/1437/4?address=Sultanahmet Mosque, Istanbul, Turkey&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByAddress', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByAddress/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByAddress/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByAddress']);

    /**
     * @api {get} http://api.aladhan.com/v1/hijriCalendarByCity/:year/:month Prayer Times Hijri Calendar by city
     * @apiDescription Returns all prayer times for a specific Hijri calendar month by City.
     * @apiName GetHijriCalendarByCity
     * @apiGroup Calendar
     * @apiVersion 1.0.1
     *
     * @apiQuery {string} city A city name. Example: London
     * @apiQuery {string} country A country name or 2 character alpha ISO 3166 code. Examples: GB or United Kindom
     * @apiQuery {string} [state] State or province. A state name or abbreviation. Examples: Colorado / CO / Punjab / Bengal
     * @apiParam {number=1-12} month Optional. A Hijri calendar month. Example: 9 or 09 for Ramadan. If not specified, an annual calendar will be returned.
     * @apiParam {number} year A Hijri calendar year. Example: 1437.
     * @apiQuery {string} x7xapikey An API key from https://7x.ax to geocode the city and country. If you do not provide one the response will mask the geocoded co-ordinates.
     * @apiQuery {number=0,1,2,3,4,5,7,8,9,10,11,12,13,14,15,99} [method] A prayer times calculation method. Methods identify various schools of thought about how to compute the timings. If not specified, it defaults to the closest authority based on the location or co-ordinates specified in the API call. This parameter accepts values from 0-12 and 99, as specified below:<br />     *                               0 - Shia Ithna-Ashari<br />
     *                               1 - University of Islamic Sciences, Karachi<br />
     *                               2 - Islamic Society of North America<br />
     *                               3 - Muslim World League<br />
     *                               4 - Umm Al-Qura University, Makkah <br />
     *                               5 - Egyptian General Authority of Survey<br />
     *                               7 - Institute of Geophysics, University of Tehran<br />
     *                               8 - Gulf Region<br />
     *                               9 - Kuwait<br />
     *                               10 - Qatar<br />
     *                               11 - Majlis Ugama Islam Singapura, Singapore<br />
     *                               12 - Union Organization islamic de France<br />
     *                               13 - Diyanet İşleri Başkanlığı, Turkey<br />
     *                               14 - Spiritual Administration of Muslims of Russia<br />
     *                               15 - Moonsighting Committee Worldwide (also requires shafaq parameter)<br />
     *                               16 - Dubai (unofficial)<br />
     *                               17 - JAKIM, Malaysia<br />
     *                               18 - Tunisia
     *                               19 - Algeria
     *                               20 - KEMENAG, Indonesia
     *                               21 - Morocco
     *                               22 - Portugal
     *                               23 - Jordan
     *                               99 - Custom. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {string} [shafaq=general] Which Shafaq to use if the method is Moonsighting Commitee Worldwide. Acceptable options are 'general', 'ahmer' and 'abyad'. Defaults to 'general'.
     * @apiQuery {string} [tune] Comma Separated String of integers to offset timings returned by the API in minutes. Example: 5,3,5,7,9,7. See <a href="https://aladhan.com/calculation-methods" target="_blank">https://aladhan.com/calculation-methods</a>
     * @apiQuery {number{0-1}} [school = 0] 0 for Shafi (or the standard way), 1 for Hanafi. If you leave this empty, it defaults to Shafii.
     * @apiQuery {number{0-1}} [midnightMode = 0] 0 for Standard (Mid Sunset to Sunrise), 1 for Jafari (Mid Sunset to Fajr). If you leave this empty, it defaults to Standard.
     * @apiQuery {number} [latitudeAdjustmentMethod=3] Method for adjusting times higher latitudes - for instance, if you are checking timings in the UK or Sweden.<br />
     *                                                 1 - Middle of the Night<br />
     *                                                 2 - One Seventh<br />
     *                                                 3 - Angle Based<br />
     * @apiQuery {number} adjustment Number of days to adjust hijri date(s). Example: 1 or 2 or -1 or -2
     * @apiQuery {boolean} [iso8601=false] Whether to return the prayer times in the iso8601 format. Example: true will return 2020-07-01T02:56:00+01:00 instead of 02:56
     *
     * @apiExample {http} Example usage:
     *   http://api.aladhan.com/v1/hijriCalendarByCity/1437/4?city=London&country=United Kingdom&method=2
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "code": 200,
     *    "status": "OK",
     *    "data": [{
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     },
     *     {
     *        "timings": {
     *            "Fajr": "03:57",
     *            "Sunrise": "05:46",
     *            "Dhuhr": "12:59",
     *            "Asr": "16:55",
     *            "Sunset": "20:12",
     *            "Maghrib": "20:12",
     *            "Isha": "22:02",
     *            "Imsak": "03:47",
     *            "Midnight": "00:59"
     *        },
     *        "date": {
     *            "readable": "24 Apr 2014",
     *            "timestamp": "1398332113",
     *            "gregorian": {
     *                "date": "15-05-2018",
     *                "format": "DD-MM-YYYY",
     *                "day": "15",
     *                "weekday": {
     *                    "en": "Tuesday"
     *                },
     *                "month": {
     *                    "number": 5,
     *                    "en": "May",
     *                },
     *                "year": "2018",
     *                "designation": {
     *                    "abbreviated": "AD",
     *                    "expanded": "Anno Domini",
     *                },
     *            },
     *            "hijri": {
     *                "date": "01-09-1439",
     *                "format": "DD-MM-YYYY",
     *                "day": "01",
     *                "weekday": {
     *                    "en": "Al Thalaata",
     *                    "ar": "الثلاثاء",
     *                },
     *                "month": {
     *                    "number": 9,
     *                    "en": "Ramaḍān",
     *                    "ar": "رَمَضان",
     *                },
     *                "year": "1439",
     *                "designation": {
     *                    "abbreviated": "AH",
     *                    "expanded": "Anno Hegirae",
     *                },
     *                "holidays": [
     *                    "1st Day of Ramadan"
     *                ],
     *            },
     *        },
     *        "meta": {
     *            "latitude": 51.508515,
     *            "longitude": -0.1254872,
     *            "timezone": "Europe/London",
     *            "method": {
     *                "id": 2,
     *                "name": "Islamic Society of North America (ISNA)",
     *                "params": {
     *                    "Fajr": 15,
     *                    "Isha": 15
     *                }
     *            },
     *            "latitudeAdjustmentMethod": "ANGLE_BASED",
     *            "midnightMode": "STANDARD",
     *            "school": "STANDARD",
     *            "offset": {
     *                "Imsak": 0,
     *                "Fajr": 0,
     *                "Sunrise": 0,
     *                "Dhuhr": 0,
     *                "Asr": 0,
     *                "Maghrib": 0,
     *                "Sunset": 0,
     *                "Isha": 0,
     *                "Midnight": 0
     *             }
     *         }
     *     }
     *     ... // More data here till the end of the month
     *     ]
     * }
     */
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByCity', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByCity/{year}/{month}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);
    $group->map(['GET', 'OPTIONS'],'/hijriCalendarByCity/{year}', [Controllers\v1\PrayerTimesCalendar::class, 'calendarByCity']);


});
