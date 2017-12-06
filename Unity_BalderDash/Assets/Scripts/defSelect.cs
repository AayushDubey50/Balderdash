using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class defSelect : MonoBehaviour {

    public Text time;
    public Button def1;
    public Button def2;
    public Button def3;
    public Button def4;
    public Button def5;
    public Button def6;
    public GameObject rsum;
    public GameObject defs;
    public camSript jg;
    public Text rnd;

    private float tme;
    // Use this for initialization
    void Start () {

        tme = 15;
        //int rm = jg.getRnd();
        //rnd.text = "Round: " + rm + "/10";
	}
	
	// Update is called once per frame
	void Update () {
        if(tme < 0)
        {
            tme = 0;
            rndSumI();
        }
        else
        {
            tme -= Time.deltaTime;
        }
        int dtme = (int)tme;
        time.text = "Time: " + dtme + " s";

    }

    public void rndSumI()
    {
        GameObject defselec = GameObject.FindGameObjectWithTag("defSelect");
        tme = 15;
        int rm = jg.getRnd();
        rnd.text = "Round: " + rm + "/10";
        defs.SetActive(false);
        rsum.SetActive(true);
    }
}


