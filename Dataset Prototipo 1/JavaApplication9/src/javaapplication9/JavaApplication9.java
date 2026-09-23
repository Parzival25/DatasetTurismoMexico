/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package javaapplication9;

/**
 *
 * @author Eduardo Pérez Hernández
 */
public class JavaApplication9 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        for (int i = 1; i < 100; i++) {
            if( (i%3)==0 && (i%5)==0){
                    System.out.println(i+" = FizzBuzz");
            }else if((i%3)==0){
                System.out.println(i+" = Fizz");
            }else if((i%5)==0 ){
                System.out.println(i +" = Buzz");
            }else{
                System.out.println(" El numero no multiplo  "+i);
            }
            
            
        }
    }
    
}
