#include <wiringPi.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <mysql/mysql.h>
#include <time.h>

#define MAX_TIMINGS	85
#define DHT_PIN		3	/* GPIO-22 */

int data[5] = { 0, 0, 0, 0, 0 };

void read_dht_data()
{
    MYSQL *conn;
    MYSQL_RES *res;
    MYSQL_ROW row;
    char *server = "localhost";
    char *user = "root";
    char *password = "pwdroot"; /* set me first */
    char *database = "pi_sense_db";
    char q[1024];
    conn = mysql_init(NULL);
    uint8_t laststate	= HIGH;
    uint8_t counter		= 0;
    uint8_t j			= 0, i;

    data[0] = data[1] = data[2] = data[3] = data[4] = 0;

    /* Connect to database */
    if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

	/* pull pin down for 18 milliseconds */
	pinMode( DHT_PIN, OUTPUT );
	digitalWrite( DHT_PIN, LOW );
	delay( 18 );

	/* prepare to read the pin */
	pinMode( DHT_PIN, INPUT );

	/* detect change and read data */
	for ( i = 0; i < MAX_TIMINGS; i++ )
	{
		counter = 0;
		while ( digitalRead( DHT_PIN ) == laststate )
		{
			counter++;
			delayMicroseconds( 1 );
			if ( counter == 255 )
			{
				break;
			}
		}
		laststate = digitalRead( DHT_PIN );

		if ( counter == 255 )
			break;

		/* ignore first 3 transitions */
		if ( (i >= 4) && (i % 2 == 0) )
		{
			/* shove each bit into the storage bytes */
			data[j / 8] <<= 1;
			if ( counter > 16 )
				data[j / 8] |= 1;
			j++;
		}
	}

	/*
	 * check we read 40 bits (8bit x 5 ) + verify checksum in the last byte
	 * print it out if data is good
	 */
	if ( (j >= 40) &&
	     (data[4] == ( (data[0] + data[1] + data[2] + data[3]) & 0xFF) ) )
	{
		float h = (float)((data[0] << 8) + data[1]) / 10;
		if ( h > 100 )
		{
			h = data[0];	// for DHT11
		}
		float c = (float)(((data[2] & 0x7F) << 8) + data[3]) / 10;
		if ( c > 125 )
		{
			c = data[2];	// for DHT11
		}
		if ( data[2] & 0x80 )
		{
			c = -c;
		}

		time_t t = time(NULL);
        struct tm tm = *localtime(&t);
        char datetime[100];

        // Prepare datetime and query for DB
        sprintf(datetime, "%d-%d-%d %d:%d:%d\n", tm.tm_year + 1900, tm.tm_mon + 1, tm.tm_mday, tm.tm_hour, tm.tm_min, tm.tm_sec);
        sprintf(q,"INSERT INTO pi_sense_db.temperatures(temperature, humidity, created_at, updated_at) VALUES(%d, %d, '%s', '%s')", (int)c, (int)h, datetime, datetime);

		/* send SQL query */
        if (mysql_query(conn, q)) {
            fprintf(stderr, "%s\n", mysql_error(conn));
            exit(1);
        }

        /* close connection */
        mysql_free_result(res);
        mysql_close(conn);

		printf( "All good!\n", (int)h, (int)c);
	}else  {
		printf( "Data not good, skip!\n" );
	}
}

int main( void )
{
	if ( wiringPiSetup() == -1 )
		exit( 1 );

	while ( 1 )
	{
		read_dht_data();
		delay(300000); /* wait 2 seconds before next read */
	}

	return 0;
}