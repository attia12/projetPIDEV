/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

import Services.ServiceLocal;

/**
 *
 * @author donia
 */
public class main {
   
    public static void main(String[] args) {


        Local p = new Local("dd","fe","gg","gg");
        
        ServiceLocal sp = new ServiceLocal();
       sp.add(p);
      //  sp.supprimer(p2);
        System.out.println( sp.afficher());
        //sp.modifier(p2);
    }
}

