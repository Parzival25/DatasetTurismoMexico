/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Project/Maven2/JavaApp/src/main/java/${packagePath}/${mainClassName}.java to edit this template
 */


import java.io.File;
import java.util.Scanner;

package com.mycompany.mavenproject1;

/**
 *
 * @author EDUAR
 */
public class Mavenproject1 {

    public static void main(String[] args) {
       File doc = new File("C:\\Drive\\Learn.txt");
        Scanner obj = new Scanner(doc);

        while (obj.hasNextLine())
            System.out.println(obj.nextLine());
    }
}
