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
public class ConversionRespaldo {
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
             try {
                    DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
                    DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
                    //Elemento raíz
                    Document doc = docBuilder.newDocument();
                    Element rootElement = doc.createElement("Atomos");
                    doc.appendChild(rootElement);
                    
                   
                   
                   
                   while (null!=line) {
            String [] fields = line.split(SEPARATOR);
             //Primer elemento
                    Element Atomo = doc.createElement("Atomo");
                    rootElement.appendChild(Atomo);
                    //Se agrega un atributo al nodo elemento y su valor
                    Attr id = doc.createAttribute("id");
                    id.setValue(fields[0]);
                    Atomo.setAttributeNode(id);
                    
                       Attr nombre = doc.createAttribute("Nombre");
                    nombre.setValue(fields[1]);
                    Atomo.setAttributeNode(nombre);
                    
                      Attr C1 = doc.createAttribute("C1");
                    C1.setValue((fields[2]));
                    Atomo.setAttributeNode(C1);
                    
                      Attr C2 = doc.createAttribute("C2");
                    C2.setValue(fields[3]);
                    Atomo.setAttributeNode(C2);
                    
                     Attr Latitud = doc.createAttribute("Latitud");
                    Latitud.setValue(fields[4]);
                    Atomo.setAttributeNode(Latitud);
                    
                     Attr Longitud = doc.createAttribute("Longitud");
                    Longitud.setValue(fields[5]);
                    Atomo.setAttributeNode(Longitud);
                    
                    Attr Activo = doc.createAttribute("Activo");
                    Activo.setValue(fields[6]);
                    Atomo.setAttributeNode(Activo);
                    
                    Attr Origen = doc.createAttribute("Origen");
                    Origen.setValue(fields[7]);
                    Atomo.setAttributeNode(Origen);
                    
                    Attr NumeroOriginal = doc.createAttribute("NumOriginal");
                    NumeroOriginal.setValue(fields[8]);
                    Atomo.setAttributeNode(NumeroOriginal);
                    
                    Attr Descripcion = doc.createAttribute("Descripcion");
                    Descripcion.setValue(fields[9]);
                    Atomo.setAttributeNode(Descripcion);
                    
                    Attr Localizacion = doc.createAttribute("Localizacion");
                    Localizacion.setValue(fields[10]);
                    Atomo.setAttributeNode(Localizacion);
                    
                    Attr ComoLlegar = doc.createAttribute("ComoLLegar");
                    ComoLlegar.setValue(fields[11]);
                    Atomo.setAttributeNode(ComoLlegar);
                    
                    Attr Actividad1 = doc.createAttribute("Actividad1");
                    Actividad1.setValue(fields[12]);
                    Atomo.setAttributeNode(Actividad1);
                    
                    Attr Actividad2 = doc.createAttribute("Actividad2");
                    Actividad2.setValue(fields[13]);
                    Atomo.setAttributeNode(Actividad2);
                    
                    Attr Actividad3 = doc.createAttribute("Actividad3");
                    Actividad3.setValue(fields[14]);
                    Atomo.setAttributeNode(Actividad3);
                    
                    Attr Actividad4 = doc.createAttribute("Actividad4");
                    Actividad4.setValue(fields[15]);
                    Atomo.setAttributeNode(Actividad4);
                    
                    Attr Actividad5 = doc.createAttribute("Actividad5");
                    Actividad5.setValue(fields[16]);
                    Atomo.setAttributeNode(Actividad5);
                    
                    Attr Foto1 = doc.createAttribute("Foto1");
                    Foto1.setValue(fields[17]);
                    Atomo.setAttributeNode(Foto1);
                    
                     Attr Foto2 = doc.createAttribute("Foto2-");
                    Foto2.setValue(fields[18]);
                    Atomo.setAttributeNode(Foto2);
                    
                     Attr Foto3 = doc.createAttribute("Foto3");
                    Foto3.setValue(fields[19]);
                    Atomo.setAttributeNode(Foto3);
                    
                     Attr Foto4 = doc.createAttribute("Foto4");
                    Foto4.setValue(fields[20]);
                    Atomo.setAttributeNode(Foto4);
                    
                     Attr Foto5 = doc.createAttribute("Foto5");
                    Foto5.setValue(fields[21]);
                    Atomo.setAttributeNode(Foto5);
                    
                     Attr Foto6 = doc.createAttribute("Foto6");
                    Foto6.setValue(fields[22]);
                    Atomo.setAttributeNode(Foto6);
                    
            //System.out.println(Arrays.toString(fields));
            
            //System.out.println("El tamaño del array es: "+fields.length);
            
            line = br.readLine();
         }
                    

//Se escribe el contenido del XML en un archivo
                    TransformerFactory transformerFactory = TransformerFactory.newInstance();
                    Transformer transformer = transformerFactory.newTransformer();
                    DOMSource source = new DOMSource(doc);
                    StreamResult result = new StreamResult(new File("/pruebaLalo.xml"));
                    transformer.transform(source, result);
           } catch (ParserConfigurationException pce) {
             pce.printStackTrace();
           } catch (TransformerException tfe) {
             tfe.printStackTrace();
           }
             
             //-----------------------Finaliza Escritor
         
         
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
