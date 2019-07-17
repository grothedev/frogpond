#include <stdio.h>
#include <string.h>
#include <stdlib.h>

//asd;lkfna;sldknfa;lskdfn

int * tt();

enum {
	nap, rico, kip, grandma
};

char characters[][10] = {
	"napoleon", "uncle_rico", "kip", "grandma"
};

int main(int argc, char * argv[]){

	//int * a = tt(5, 5);

	/*char * s = "Tina";
	int j = 3;
	int i;
	for (i = 0; i < 5; i++){
		characters[grandma][i] = *s++;
	}
	printf("%s\n", s = characters[grandma]);

	strcpy(characters[rico], "starla");
	printf("%s\n", characters[rico]);
	*/

	char *str = "327";
	union foo{
		int i;
		short j[2];
		char k[8];
	};
	printf("%lu\n", sizeof(union foo) );
}

/*
int * tt(int rows, int columns){
	int * p = malloc(rows * 4 * columns * 4);
	if (p == NULL) return NULL;

	//int a[rows][columns] = *p;

	int i, j;
	for (i = 0; i < rows; i++){
		for (j = 0; j < columns; j++){
			(*p * 4*i + 4*j) = (i+1) * (j+1);
		}
	}

	return p;
}
*/
