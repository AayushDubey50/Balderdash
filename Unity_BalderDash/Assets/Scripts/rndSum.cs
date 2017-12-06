using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class rndSum : MonoBehaviour {

    public Text time;
    private float tme;
    bool gmO;
    public GameObject def;
    public GameObject endGame;
    public GameObject rsm;
    public camSript jg;
    public Text rnd;

    // Use this for initialization
    void Start () {
        tme = 10;
        gmO = false;
        
    }
	
	// Update is called once per frame
	void Update () {

        if(tme < 0)
        {
            tme = 0;
            nxtRnd();
        }
        else
        {
            tme -= Time.deltaTime;
        }
        int dtme = (int)tme;
        time.text = "Time: " + dtme + " s";

    }

    public void nxtRnd()
    {
        GameObject curr = GameObject.FindGameObjectWithTag("rndSum");
        tme = 10;
        rsm.SetActive(false);
        if (jg.getRnd() == 10)
        {
            endGame.SetActive(true);
        }
        else
        {
            jg.setRnd();
            int rm = jg.getRnd();
            rnd.text = "Round: " + rm + "/10";
            def.SetActive(true);
        }
            
    }
}
