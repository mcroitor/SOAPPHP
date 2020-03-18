#include <iostream>
#include <string>
#include <algorithm>

const int MULTIPLIER = 3;
const int CONSTANT = 5;

char encode(char c){
    int index = c - 'a';
    int new_index = (MULTIPLIER * index + CONSTANT) % 26;
    return 'a' + (char)new_index;
}

char decode(char c){
    int index = c - 'a';
    int new_index = index + 26;
    while((new_index - CONSTANT) % MULTIPLIER != 0){
        new_index += 26;
    }
    new_index /= MULTIPLIER;
    new_index -= CONSTANT;
    return 'a' + (char)new_index;
}

int main(int argc, char** argv) {
    std::string str = "abcdefghijklmnopqrstuvwxyz";
    
    std::string encoded = str;
    std::string decoded = str;
    std::transform(str.begin(), str.end(), encoded.begin(), encode);
    std::transform(encoded.begin(), encoded.end(), decoded.begin(), decode);
    
    std::cout << "initial = " << str << std::endl;
    std::cout << "encoded = " << encoded << std::endl;
    std::cout << "decoded = " << decoded << std::endl;
    return 0;
}

