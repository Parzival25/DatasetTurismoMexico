/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Creacion;


import com.opencsv.CSVReader;
import com.opencsv.exceptions.CsvValidationException;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.TransformerException;
//
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Result;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.w3c.dom.DOMImplementation;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Text;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;
import java.util.ArrayList;
import java.util.Arrays;
import java.io.*;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.nio.charset.StandardCharsets;

/**
 *
 * @author Eduardo Pérez Hernández
 */
public class Main {
    public static final String SEPARADOR = ";";
    
public static void main(String[] args) {
 
   BufferedReader bufferLectura = null;
   try {
         // Abrir el .csv en buffer de lectura
         bufferLectura = new BufferedReader(new FileReader("D:\\Residencia\\Prototipo 4\\Datos.csv"));

         // Leer una linea del archivo
         String linea = bufferLectura.readLine();
        
        
        
      
      //-----------------------------------------------------------------------------------------------------------------------------------------
      
        while (linea != null) {
             String nombreFichero = "D:\\Residencia\\Prototipo 4\\beryllium\\index.html";
             String[] campos = linea.split(SEPARADOR);
            // Sepapar la linea leída con el separador definido previamente
               // Declarar una variable BufferedReader
         BufferedReader br = null;
         
         
         FileWriter fichero = null;
         PrintWriter pw = null;
                     fichero = new FileWriter("D:\\Residencia\\Prototipo 4\\beryllium\\"+campos[0]+".html", StandardCharsets.UTF_8);
          pw = new PrintWriter(fichero);
         

         try {
                // Crear un objeto BufferedReader al que se le pasa 
                //   un objeto FileReader con el nombre del fichero
                br = new BufferedReader(new FileReader(nombreFichero));
                // Leer la primera línea, guardando en un String
                String texto = br.readLine();

                
                



                // Repetir mientras no se llegue al final del fichero
                int ontoy=1;
//                System.out.println(campos[0]);
           
            
                while(texto != null) {
         
                    // Hacer lo que sea con la línea leída
                    // En este ejemplo sólo se muestra por consola

                   
//                        System.out.println("----------------- AQUI ------------------");


                       
                            if(ontoy==12){
                                  pw.println(campos[1]);
                            }else if(ontoy==85){
                                for (int i = 18; i < 23; i++) {
                                   if(!campos[i].equalsIgnoreCase("")  ){
//                                       System.out.println(campos[4]);
                                        
                                           pw.println(""+ 
"						<div class=\"item\">\n" +
"							<a href=\"#\">\n" +
"								<img src=\"");
//                                           System.out.println(campos[7]);
                                           
                                        if(campos[7].equalsIgnoreCase("1")){
                                            
                                         pw.print("..\\beryllium\\0001"+campos[i].substring(2));
                                         
                                          }else  if(campos[7].equalsIgnoreCase("2")){
                                         pw.print("..\\beryllium\\0002"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("3")){
                                         pw.print("..\\beryllium\\0003"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("4")){
                                         pw.print("..\\beryllium\\0004"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("5")){
                                         pw.print("..\\beryllium\\0005"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("6")){
                                         pw.print("..\\beryllium\\0006"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("7")){
                                         pw.print("..\\beryllium\\0007"+campos[i].substring(2));
                                          }else  if(campos[7].equalsIgnoreCase("8")){
                                         pw.print("..\\beryllium\\0008"+campos[i].substring(2));
                                          }
                                         pw.println("\" \n" +
"								>\n" +
"								<div class=\"slider-copy\">\n" +
"									<!-- <h2>Architecture #1</h2> -->\n" +
"								</div>\n" +
"							</a>\n" +
"						</div>");
                                   
                                }
                                }
                                
                            }else if(ontoy==111){
                                  pw.println("<h2>"+campos[1]+"</h2>");
                            }
                            else if(ontoy==113){
                                  pw.println(campos[9]);
                            }else if(ontoy==131){
                                  pw.println(campos[10]);
                            }else if(ontoy==143){
                                  pw.println(campos[11]);
                            }else if(ontoy==155){
                                  pw.println(campos[12]);
                            }
                            else{
                                  pw.println(texto);
                            }
                         
                           
                              

                   


//                    System.out.println(texto);
                    texto = br.readLine();
                    ontoy++;   
                }
                ontoy=0;
            }
         
         
            // Captura de excepción por fichero no encontrado
            catch (FileNotFoundException ex) {
                System.out.println("Error: Fichero no encontrado");
                ex.printStackTrace();
            }
            // Captura de cualquier otra excepción
            catch(Exception ex) {
                System.out.println("Error de lectura del fichero");
                ex.printStackTrace();
            }
            // Asegurar el cierre del fichero en cualquier caso
            finally {
                pw.close();
                 fichero.close();
                try {
                    // Cerrar el fichero si se ha podido abrir
                    if(br != null) {
                        br.close();
                    }
                }
                catch (Exception ex) {
                    System.out.println("Error al cerrar el fichero");
                    ex.printStackTrace();
                }
            }
        



//            System.out.println(Arrays.toString(campos));

            // Volver a leer otra línea del fichero
            linea = bufferLectura.readLine();
            campos=null;
        }
    }catch (IOException e) {
        e.printStackTrace();
    }finally {
        // Cierro el buffer de lectura
        if (bufferLectura != null) {
            try {
             bufferLectura.close();
            } 
            catch (IOException e) {
             e.printStackTrace();
            }
        }
    }
 
}
    
}
