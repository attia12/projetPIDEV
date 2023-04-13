/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Local;

import Entity.Consultation;
import Entity.Local;
import Services.ServiceLocal;

/**
 *
 * @author donia
 */
public class Main {

     public static void main(String[] args) {


        Local p = new Local("dd","fe","gg","gg");
        Local p2 = new Local("ABIR","fe","gg","gg");
        ServiceLocal sp = new ServiceLocal();
        // sp.add(p2);
       // sp.supprimer(p);
       System.out.println( sp.afficher());
       // sp.modifier(p2);
         //      Consultation p = new Consultation("dd","fe","gg","gg");

    }
    
}
