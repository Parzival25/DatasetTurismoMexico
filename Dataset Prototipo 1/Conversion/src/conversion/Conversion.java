/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */

package conversion;

import com.opencsv.CSVReader;
import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.Arrays;


import java.io.File;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Element;

/**
 *
 * @author Eduardo Pérez Hernández
 */
public class Conversion {
   public static final String SEPARATOR=";";
   public static final String QUOTE="\"";

    /**
     * @param args the command line arguments
     * @throws java.io.IOException
     */
    public static void main(String[] args) throws IOException {
        // TODO code application logic here
        //------------------------------------------------Fin lector
      FileInputStream fis = new FileInputStream("D:/Residencia/Prototipo 4/Datos.csv");
      InputStreamReader is = new InputStreamReader(fis, "ISO-8859-1");
      BufferedReader br = new BufferedReader(is);
      
      try {
         
         String line = br.readLine();
         
         //------------------------------Inicia el Escritor
         
         while (null!=line) {
            String [] fields = line.split(SEPARATOR);
            System.out.println(Arrays.toString(fields));
            
            System.out.println("El tamaño del array es: "+fields.length);
            
            line = br.readLine();
         }
         
      } catch (IOException e) {
          System.out.println(e);
      } finally {
         if (null!=br) {
            br.close();
         }
      }
      //------------------------------------------------Fin lector
      
    }

}
