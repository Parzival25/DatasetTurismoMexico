/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package a;

/**
 *
 * @author EDUAR
 */

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathExpressionException;
import javax.xml.xpath.XPathFactory;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

/**
 *
 * @author david
 */
public class XPathReader {



    

    
  static ArrayList<AtomosLocalizacion> localizaciones = new ArrayList<AtomosLocalizacion>();
    public XPathReader() {
//    public static void main(String[] args) {
        
        try {
            // Generador de constructor de objetos XML
            DocumentBuilderFactory documentBuilderFactory = DocumentBuilderFactory.newInstance();

            // Esto es para agilizar la lectura de archivos grandes
            documentBuilderFactory.setNamespaceAware(false);
            documentBuilderFactory.setValidating(false);
            documentBuilderFactory.setFeature("http://xml.org/sax/features/namespaces", false);
            documentBuilderFactory.setFeature("http://xml.org/sax/features/validation", false);
            documentBuilderFactory.setFeature("http://apache.org/xml/features/nonvalidating/load-dtd-grammar", false);
            documentBuilderFactory.setFeature("http://apache.org/xml/features/nonvalidating/load-external-dtd", false);

            // constructor de objetos XML
            DocumentBuilder documentBuilder = documentBuilderFactory.newDocumentBuilder();
            
            // Ruta del archivo XML
            String nombreArchivo = "D:\\Residencia\\Prototipo 1\\turismo_chiapas\\xml\\Marcadores.xml";
            File archivo = new File(nombreArchivo);
            
            // Objeto Documento XML
            Document documento = documentBuilder.parse(archivo);

            // Esto ayuda al procesamiento
            documento.getDocumentElement().normalize();

            // XPath nos permite seleccionar objetos via su ubicacion en la estructura del XML
            XPath xPath = XPathFactory.newInstance().newXPath();
            
            // La ruta del elemento que deseamos, para este omitir el prefijo cfdi:
            String expresionMarcador=  "/marcadores/marcador";
            
            // Obtenemos todos los nodos que empatan con la ruta que indicamos
            NodeList nodeListTranslados = (NodeList) xPath.compile(expresionMarcador).evaluate(documento, XPathConstants.NODESET);
            
            
           
            for (int i = 0; i < nodeListTranslados.getLength(); i++) {
            Element marcador = (Element) nodeListTranslados.item(i);
            if(marcador.getAttribute("or").equalsIgnoreCase("1")){
                AtomosLocalizacion atomo=new AtomosLocalizacion();
                atomo.setId(marcador.getAttribute("id"));
                atomo.setNombre(marcador.getAttribute("nombre"));
                atomo.setLatitud(marcador.getAttribute("lat"));
                atomo.setLongitud(marcador.getAttribute("lng"));
                atomo.setOrigen(marcador.getAttribute("or"));
                atomo.setNumeroOriginal(marcador.getAttribute("numOr"));
                localizaciones.add(atomo);
            }
            
        
            }
       

            

        } catch (SAXException | IOException | ParserConfigurationException | XPathExpressionException ex) {
            Logger.getLogger(XPathReader.class.getName()).log(Level.SEVERE, null, ex);
        }
//        for (int i = 0; i < localizaciones.size(); i++) {
////                private String id;
////                private String nombre;
////                private String latitud;
////                private String longitud;
////                private String origen;
////                private String numeroOriginal;
//            System.out.println(localizaciones.get(i).getId());
//            System.out.println(localizaciones.get(i).getNombre());
//            System.out.println(localizaciones.get(i).getLatitud());
//            System.out.println(localizaciones.get(i).getLongitud());
//            System.out.println(localizaciones.get(i).getOrigen());
//            System.out.println(localizaciones.get(i).getNumeroOriginal());
//            System.out.println("---------------------------------------------------------");
//            
//        }
    }

}
